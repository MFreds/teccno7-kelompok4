<?php

namespace App\Http\Controllers;

use App\Services\Midtrans\CreateSnapTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\CustomBundleCart;

use DataTables;

class OrderController extends Controller
{
    public function getOrder(Request $request) {

        if ($request->ajax()) {
            try {
                $data = DB::table('orders')->where('payment_status', '2')->get();

                return Datatables::of($data)
                    ->addIndexColumn()
                    ->make(true);
            } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMsg = $e->errorInfo[2];
                return response($e, 200);
            }
        }
    }

    public function getPejualanData(Request $request) {
        // if ($request->ajax()) {
            try {
                $grafik = DB::select("SELECT CAST(created_at AS DATE) AS date, SUM(total_price) AS sum, count(id) as count FROM orders GROUP BY CAST(created_at AS DATE)");
                $summary = DB::select("SELECT COUNT(id) AS count, SUM(total_price) AS sum FROM orders");

                return response([
                    'summary' => $summary,
                    'graph' => $grafik
                ], 200);
            } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $errorMsg = $e->errorInfo[2];
                return response($e, 200);
            }
        // }
    }

    public function newOrder(Request $request) {

        $order_uuid = (string) Str::uuid();

        $custom_bundle_cart = [];
        $total_price_all = 0;

        $id = auth()->user()->id;

        $custom = CustomBundleCart::where('user_id', $id)->get();

        foreach($custom as $index => $c) {
            $tmpCustomBndlID = $c->id;

            $bundleItems = DB::table('custom_bundle_item_carts as a')
                                ->select('b.name as item_name', 'b.price as item_price', 'a.amount as amount', 'a.total_price as total_price', 'a.additional_note as note')
                                ->join('items as b', 'b.id', '=', 'a.item_id')
                                ->where('a.custom_bundle_cart_id', $tmpCustomBndlID)->get()->toArray();

            $custom_bundle_cart[$tmpCustomBndlID]['amount'] = $c->amount;
            $custom_bundle_cart[$tmpCustomBndlID]['total_price'] = $c->total_price;
            $custom_bundle_cart[$tmpCustomBndlID]['data'] = $bundleItems;

            $total_price_all = $total_price_all + (int)$c->total_price;
        }

        // dd($request);
        // dd($custom_bundle_cart);
        // dd(serialize($custom_bundle_cart), unserialize(serialize($custom_bundle_cart)));

        $order_id = '';

        try {
            $order = Order::create([
                'uuid' =>  $order_uuid,
                'user_id' => auth()->user()->id,
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'postal' => $request->postal,
                'phone' => $request->phone,
                'total_price' => $total_price_all,
                'payment_status' => '1',
                'order_items' => serialize($custom_bundle_cart)
            ]);

            $order_id = $order->id;

            DB::table('custom_bundle_item_carts')->where('user_id', '=',  $id)->delete();
            DB::table('custom_bundle_carts')->where('user_id', '=',  $id)->delete();

            // DB::table('carts')->where('user_id', '=', $id)->delete();

        }catch(\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMsg = $e->errorInfo[2];
            if ($errorCode == 1062) {
                return redirect('/');
            }

            dd($errorMsg);
        } catch (\Exception $e) {

            dd($e->getMessage());
        }

        return redirect()->route('order.show', ['id' => $order_id]);
        // return redirect()->back()->with('success', 'Order made successfully.');
    }

    public function show($id)
    {
        $order = Order::find($id);
        $snapToken = $order->snap_token;
        if (is_null($snapToken) || $snapToken == '') {
            // If snap token is still NULL, generate snap token and save it to database

            $midtrans = new CreateSnapTokenService($order);
            $snapToken = $midtrans->getSnapToken();

            $order->snap_token = $snapToken;
            $order->save();
        }

        // dd($order, $snapToken);

        return view('order.show', compact('order', 'snapToken'));
    }
}

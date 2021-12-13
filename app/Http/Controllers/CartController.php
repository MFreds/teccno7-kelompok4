<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

use App\Models\CustomBundleCart;
use App\Models\CustomBundleItemCart;

class CartController extends Controller
{
    public function show() {

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

        // dd($custom_bundle_cart);

        return view('cart.show')
            ->with('account', auth()->user())
            ->with('total_price_all', $total_price_all)
            ->with('customBundle', $custom_bundle_cart);
    }

    public function addCustomBundle(Request $request) {

        // dd($request);
        if (auth()->user() == null) {
            return redirect()->back()->with('success', 'Login first.');
        }

        $cart_uuid = (string) Str::uuid();
        $cart_id = '';

        try {
            $cart = CustomBundleCart::create([
                'uuid' =>  $cart_uuid,
                'total_price' => $request->total_price,
                'amount' => 1,
                'user_id'=> auth()->user()->id
            ]);

            $cart_id = $cart->id;
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

        $item_id = $request->item_id;
        $item_price = $request->item_price;
        $item_amount = $request->item_count;
        $item_notes = $request->additional_note;

        foreach($item_id as $index => $item) {

            try {
                CustomBundleItemCart::create([
                    'uuid' => (string) Str::uuid(),
                    'custom_bundle_cart_id' => $cart_id,
                    'item_id' => $item_id[$index],
                    'amount' => $item_amount[$index],
                    'total_price' => (int)$item_amount[$index] * (int)$item_price[$index],
                    'additional_note' => $item_notes[$index],
                    'user_id' => auth()->user()->id
                ]);
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
        }

        return redirect()->back()->with('success', 'Added to cart successfully.');
    }
}

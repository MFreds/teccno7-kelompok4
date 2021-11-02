<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Models\Item;

class ItemController extends Controller
{
    public function createForm() {
        return view('item.create');
    }

    public function create(Request $request) {
        // dd($request);

        $user_id = Auth::user()->id;
        $uuid_str = (string) Str::uuid();

        $this->validate($request, [
            'item_name' => 'required',
            'item_description' => 'required',
            'item_price' => 'required',
            'item_stock' => 'required'
        ]);

        // photo process
        $photo = $request->file('item_photo');
        $content = file_get_contents($photo->getRealPath());
        $photo_ext = $photo->getClientOriginalExtension();
        $file_name = 'item-' .$user_id . $uuid_str . '.' . $photo_ext;

        Storage::put('public/item_photos/' . $file_name, $content);

        try {
            $newItem = Item::create([
                'name' => $request->item_name,
                'uuid' => $uuid_str,
                'photo' => asset('storage/item_photos/' . $file_name),
                'description' => $request->item_description,
                'price' =>  $request->item_price,
                'status' => 'open',
                'stock' => $request->item_stock
            ]);

            return redirect()->back()->with('success', $newItem->name . ' created successfully.');

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

        return redirect()->back()->with('error', 'Something bad happened :(');
    }
}

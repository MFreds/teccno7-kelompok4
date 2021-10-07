<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cart;

class cartAPIController extends Controller
{
    public function addItemToCart(Request $request) {

        $data = $request->all();

        try {
            $newCartItem = Cart::create([
                'user_id' => $data['user_id'],
                'item_type' => $data['item_type'],
                'item_id' => $data['item_id'],
                'price' => $data['price'],
                'total_price' => $data['total_price'],
                'amount' => $data['amount'],
                'additional_note' => $data['additional_note']
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'code' => 500,
                'success'=> false,
                'errors' => [$e->getMessage()]
            ]);
        }

        return response()->json([
            'code' => 200,
            'success'=> true,
            'data' => $newCartItem
        ]);
    }
}

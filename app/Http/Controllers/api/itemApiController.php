<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Item;

class itemApiController extends Controller
{
    public function getAllItem() {
        $data = Item::all();

        return response()->json([
            'code' => 200,
            'success'=>true,
            'data' => $data
        ]);
    }

    public function getSingleItem($id) {

        $item = Item::where('uuid', $id)->first();

        return response()->json([
            'code' => 200,
            'success'=>true,
            'data' => $item
        ]);
    }
}

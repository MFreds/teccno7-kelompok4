<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Bundle;

class bundleApiController extends Controller
{
    public function getPromoBundles() {
        $data = Bundle::where('tags', 'like', '%promo%')->get();

        return response()->json([
            'code' => 200,
            'success'=>true,
            'data' => $data
        ]);
    }
}

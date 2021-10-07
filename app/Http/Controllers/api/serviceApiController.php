<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Service;

class serviceApiController extends Controller
{
    public function getAllServices() {
        $data = Service::all();

        return response()->json([
            'code' => 200,
            'success'=>'testing successfully',
            'data' => $data
        ]);
    }
}

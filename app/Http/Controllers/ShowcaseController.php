<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShowcaseController extends Controller
{
    public function testThreeJs() {
        return view('product.test');
    }
}

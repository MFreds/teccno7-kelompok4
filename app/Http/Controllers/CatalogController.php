<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Bundle;

class CatalogController extends Controller
{
    public function getCatalogList()
    {
        $allBundle = Bundle::latest()->get();
        $promoBundle = Bundle::where('tags', 'like', '%promo%')->get();

        $data =  array();
        $data['all'] = $allBundle;
        $data['promo'] = $promoBundle;

        return view('catalog.list', compact("data"));
    }
}

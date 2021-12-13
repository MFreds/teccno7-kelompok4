<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomBundleItemCart extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid', 'custom_bundle_cart_id', 'item_id',
        'amount', 'total_price', 'additional_note', 'user_id'
    ];
}

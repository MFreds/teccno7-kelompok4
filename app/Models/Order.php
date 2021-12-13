<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',

        'user_id', 'name',
        'email', 'address',
        'city', 'postal', 'phone',
        'order_items',

        'total_price', 'payment_status',
        'token'
    ];
}

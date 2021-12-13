<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomBundleCart extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid', 'total_price', 'amount', 'user_id'
    ];
}

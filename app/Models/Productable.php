<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productable extends Model
{
    // Cambio por IA
    protected $table = 'prodcutables';

    protected $fillable = [
        'product_id',
        'prodcutable_id',
        'prodcutable_type',
        'quantity',
        'price',
        'subtotal',
    ];
}

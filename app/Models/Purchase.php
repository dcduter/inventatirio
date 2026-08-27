<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    // Cambio por IA
    protected $fillable = [
        'voucher_type',
        'serie',
        'correlative',
        'date',
        'purchase_order_id',
        'supplier_id',
        'warehouse_id',
        'total',
        'observation',
    ];

    // Relacion muchos a muchos polimorfica
    public function products (){


         return $this->morphToMany(Product::class, 'productable')->withPivot('quantity','price','subtotal')->withTimestamps();
       }
    }

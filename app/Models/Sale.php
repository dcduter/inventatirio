<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    // Cambio por IA
    protected $fillable = [
        'voucher_type',
        'serie',
        'correlative',
        'date',
        'quote_id',
        'costumer_id',
        'warehouse_id',
        'total',
        'observation',
    ];

        // Relacion una a muchas inversa
    public function Customer(){
        return $this->belongsTo(Customer::class);
    }

        // Relacion muchos a muchos polimorfica
    public function products (){


         return $this->morphToMany(Product::class, 'productable')->withPivot('quantity','price','subtotal')->withTimestamps();
       }
}

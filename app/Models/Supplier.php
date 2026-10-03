<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    //

    use HasFactory;
    // cambio por IA: corregido document_number y agregado name para asignación masiva
    protected $fillable = [
        'identity_id',
        'document_number',
        'name',
        'address',
        'email',
        'phone',
    ];

        // Relacion uno a muchos inversa
    public function identity() {

        return $this->belongsTo(Identity::class);
    }

    // Realcion una a muchos

    public function purchaseOrders(){

        return $this->hasMany(PurchaseOrder::class);
    }
    
    public function purchases(){

        return $this->hasMany(Purchase::class);
    }
}

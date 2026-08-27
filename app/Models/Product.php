<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Cambio por IA
    protected $fillable = [
        'name',
        'description',
        'sku',
        'barcode',
        'price',
        'category_id',
    ];

    // Relacion una a muchas inversa
    public function category(){
        return $this->belongsTo(Category::class);
    }

    // Relacion uno a muchos
    public function inventories(){
        return $this->hasMany(Inventory::class, 'inventoryable');
    }

    // Relacion muchos a muchos polimorfica
    public function images(){
        return $this->morphToMany(Image::class, 'imageable');
    }
}

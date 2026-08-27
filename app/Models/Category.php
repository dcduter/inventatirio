<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Cambio por IA
    protected $fillable = [
        'name',
        'description',
    ];

    // Relacion una a muchas
    public function products(){
        return $this->hasMany(Product::class);
    }
}

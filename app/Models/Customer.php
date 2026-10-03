<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    use HasFactory;
    // cambio por IA: Atributos asignables masivamente correspondientes a la tabla customers
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
    
    // Relacion una a muchos
    public function quotes() {

        return $this->hasMany(Quote::class);
    }
    public function sales() {

        return $this->hasMany(Sale::class);
    }
}

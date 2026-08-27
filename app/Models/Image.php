<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    // Cambio por IA
    protected $fillable = [
        'path',
        'size',
        'imageable_id',
        'imageable_type',
    ];
    
    // Relacion polimorfica
    public function imageable(){
        return $this->morphTo();
    }
}

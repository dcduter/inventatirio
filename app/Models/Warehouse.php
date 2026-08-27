<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    // Cambio por IA
    protected $fillable = [
        'name',
        'location',
    ];
}

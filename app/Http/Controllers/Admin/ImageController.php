<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function destroy(Image $image){
        Storage::delete($image->path); // elimina la imagen del disco duro
        $image->delete(); // elimina el registro de la base de datos

      /*       // cambio por IA: Especificar el disco 'public' para asegurar que borre el archivo correcto
        Storage::disk('public')->delete($image->path);
        $image->delete();  */
    }
}

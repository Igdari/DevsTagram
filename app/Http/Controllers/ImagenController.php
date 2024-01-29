<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    public function store(Request $request)
    {
        $imagen = $request->file('file');

        $nombreImagen = Str::uuid(). "." . $imagen->extension();//Crea un nombre Unico para guardar
        $imagenServidor = Image::make($imagen);
        $imagenServidor->fit(1000, 1000);//Cortar la imagen a mil x mil pixeles

        $imagenPath = public_path('uploads') . "/" . $nombreImagen;//Nombre y ubicacion donde se guardara
        $imagenServidor->save($imagenPath);

        return response()->json(['imagen' => $nombreImagen]);
    }
}

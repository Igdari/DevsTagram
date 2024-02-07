<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('perfil.index');
    }



    public function store(Request $request) 
    {
        // Modificar el request del username para quitar espacios y caracteres especiales como tildes
        $request->request->add(['username' => Str::slug($request->username)]);


        //Si intento cambiar password agrego una validacion para la password nueva
        // if($request->new_password != NULL) {
            
        //     //Autentico que el usuario sea el correcto
        //     if (!auth()->attempt($request->only('email','password'))) {
        //         return back()->with('mensaje', 'Credenciales Incorrectas');
        //     }
        //     // dd('valido bien');
        //     //Agrego validacion
        //     $this->validate($request, [
        //         'username' => [ 'required', 
        //                         'unique:users,username,'.auth()->user()->id, //Que el usuario sea unico, pero que no tome mi usuario actual como invalido
        //                         'min:3', 
        //                         'max:20', 
        //                         'not_in:twitter,editar-perfil'], //Lista de nombres no permitidos
        //         'email' => [    'required',
        //                         'unique:users,email,'.auth()->user()->id,
        //                         'email',
        //                         'max:60'],
        //         'new_password' => 'required|min:6'
        //     ]);
            
           
        // } else { //Si n intento cambiar la contraseña no valido los campos de la misma
            $this->validate($request, [
                'username' => [ 'required', 
                                'unique:users,username,'.auth()->user()->id, //Que el usuario sea unico, pero que no tome mi usuario actual como invalido
                                'min:3', 
                                'max:20', 
                                'not_in:twitter,editar-perfil'], //Lista de nombres no permitidos
                'email' => [    'required',
                                'unique:users,email,'.auth()->user()->id,
                                'email',
                                'max:60'],
            ]);
        // }
        
        //Valido y configuro la imagen para guardarla
        if($request->imagen) {
            $imagen = $request->file('imagen');
            $nombreImagen = Str::uuid(). "." . $imagen->extension();//Crea un nombre Unico para guardar
            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000, 1000);//Cortar la imagen a mil x mil pixeles
            $imagenPath = public_path('perfiles') . "/" . $nombreImagen;//Nombre y ubicacion donde se guardara
            $imagenServidor->save($imagenPath);
        } 
       

        //Guardar cambios
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username; //Guardo el username
        $usuario->email = $request->email; //Cambio email
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? NULL; //Primero elige el nombre de imagen. Si no tiene, usa la que ya existe. Sino tiene lo setea a NULL
        // $usuario->password = Hash::make($request->new_password);
        $usuario->save();

        //Redireccionar al usuario
        return redirect()->route('posts.index', $usuario->username);

    }
}
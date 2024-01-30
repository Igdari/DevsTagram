<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(User $user)
    {
        return view('dashboard', [
            'user'=> $user
        ]);
    }

    public function create(User $user)
    {

        $posts = Post::where('user_id', $user->id)->get();

        return view('posts.create',[
            'user'=> $user,
            'posts'=> $posts
        ]);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'titulo' => 'required|max:255',
            'descripcion' => 'required|max:255',
            'imagen' => 'required'
        ]);

        //guardar/crear registros en base de datos
        // Post::create ([
        //     'titulo'=> $request->titulo,
        //     'descripcion' => $request->descripcion,
        //     'imagen' => $request->imagen,
        //     'user_id' => auth()->user()->id
        // ]);

        //Otra forma de crear/guardar registro
        // $post = new Post;
        // $post->titulo = $request->titulo;
        // $post->descripcion = $request->descripcion;
        // $post->imagen = $request->imagen;
        // $post->user_id = auth()->user()->id;
        // $post->save();

        $request->user()->posts()->create([
            'titulo'=> $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('posts.index', auth()->user()->username);
    }
}
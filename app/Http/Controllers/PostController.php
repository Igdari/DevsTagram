<?php

namespace App\Http\Controllers;

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
        return view('posts.create',[
            'user'=> $user
        ]);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'titulo' => 'required|max:255',
            'descripcion' => 'required|max:255',
            'imagen' => 'required'
        ]);
    }
}
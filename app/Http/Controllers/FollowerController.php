<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function store(User $user)
    {
        //Agrego el follower a la tabla de follower
        $user->followers()->attach( auth()->user()->id );
        return back();
    }

    public function destroy(User $user)
    {
        //Alimino el follower de la tabla follower
        $user->followers()->detach( auth()->user()->id );
        return back();
    }
}

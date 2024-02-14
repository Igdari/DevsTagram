<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LikePost extends Component
{

    public $post;
    public $isLiked;
    public $likes;
    
    //Monto las funcionabilidades de si esta likeado y cuandos likes tiene
    public function mount($post)
    {
        $this->isLiked = $post->checkLike(auth()->user());
        $this->likes = $post->likes->count();
    }


    public function like()
    {
        if ($this->post->checkLike(auth()->user())) {
            $this->post->likes()->where('post_id', $this->post->id)->delete();
            $this->isLiked = false; //El like queda en color blanco en vivo
            $this->likes--; //Resto uno al numero total de likes en vivo
        } else {
            $this->post->likes()->create([
                'user_id' => auth()->user()->id
            ]);
            $this->isLiked = true;//El like queda en color rojo en vivo
            $this->likes++; //Sumo uno al numero total de likes en vivo
        }
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}

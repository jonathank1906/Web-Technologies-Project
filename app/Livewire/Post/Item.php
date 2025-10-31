<?php

namespace App\Livewire\Post;

use App\Models\Post;
use Livewire\Component;

class Item extends Component
{

    public Post $post;

    function togglePostLike()
    {
        abort_unless(auth()->check(), 401);
        auth()->user()->toggleLike($this->post);
    }

    public function mount(Post $post)
    {
        $this->post = $post->loadCount('likes');
    }

    public function render()
    {
        return view('livewire.post.item');
    }
}

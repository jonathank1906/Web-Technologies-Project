<?php
namespace App\Livewire\Post;

use App\Models\Post;
use Livewire\Component;

class Show extends Component
{
    public Post $post;

    public function mount(Post $post)
    {
        $this->post = $post->load(['user', 'media', 'comments.user'])->loadCount('likes');
    }

    public function render()
    {
        return view('livewire.post.show');
    }
}
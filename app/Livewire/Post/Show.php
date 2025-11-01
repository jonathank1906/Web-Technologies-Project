<?php
namespace App\Livewire\Post;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Component;

class Show extends Component
{
    public Post $post;
    public $body;
    public $parent_id=null;

    function addComment() {
        $this->validate(rules:['body'=>'required']);

        # Create comment
        Comment::create([
            'body'=>$this->body,
            'parent_id'=>$this->parent_id,
            'commentable_id'=>$this->post->id,
            'commentable_type'=>Post::class,
            'user_id'=>auth()->id(),
        ]);
        $this->reset('body');
        $this->post = $this->post->fresh(['user', 'media', 'comments.user'])->loadCount('likes', 'comments');
    }

    public function mount(Post $post)
    {
        $this->post = $post->load(['user', 'media', 'comments.user'])->loadCount('likes', 'comments');
    }

    public function render()
    {
        $comments = $this->post->comments;
        return view('livewire.post.show',data:['comments'=>$comments]);
    }
}
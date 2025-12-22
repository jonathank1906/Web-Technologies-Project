<?php

namespace App\Livewire\Post;

use App\Models\Post;
use Livewire\Component;

class Item extends Component
{
    public Post $post;
    public $likesCount;
    public $commentsCount;

    public function togglePostLike()
    {
        abort_unless(auth()->check(), 401);
        auth()->user()->toggleLike($this->post);
        
        // Update the counts after toggling like
        $this->updateCounts();
    }

    public function mount(Post $post, $likesCount = null, $commentsCount = null)
    {
        $this->post = $post;
        $this->likesCount = $likesCount ?? $post->likes_count;
        $this->commentsCount = $commentsCount ?? $post->comments_count;
    }

    private function updateCounts()
    {
        // If we have filtered counts, we need to recalculate them
        // For now, we'll just refresh the post counts
        $this->post->loadCount('likes', 'comments');
        $this->likesCount = $this->post->likes_count;
        $this->commentsCount = $this->post->comments_count;
    }

    public function render()
    {
        return view('livewire.post.item');
    }

    public function destroy()
    {
        // Force delete comments first (bypass soft delete)
        \App\Models\Comment::where('commentable_id', $this->post->id)
            ->where('commentable_type', Post::class)
            ->forceDelete();

        $postId = $this->post->id;
        $this->post->delete();
        $this->dispatch('post-deleted', $postId);
        session()->flash('status', 'Post deleted!');
    }
}
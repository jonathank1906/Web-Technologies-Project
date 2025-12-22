<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Post;
use App\Models\Block;

class Home extends Component
{
    public $posts;

    #[On('post-created')]
    function postCreated($id)
    {
        $post = Post::find($id);
        
        // Check if the post author is blocked by current user or has blocked current user
        if ($this->shouldHidePost($post)) {
            return; // Don't add the post to the feed
        }

        $this->posts = $this->posts->prepend($post);
    }

    function mount() {
        if (auth()->check()) {
            // Get users that current user has blocked
            $blockedUserIds = Block::where('blocker_id', auth()->id())
                ->pluck('blocked_id')
                ->toArray();
            
            // Get users who have blocked current user
            $usersWhoBlockedMe = Block::where('blocked_id', auth()->id())
                ->pluck('blocker_id')
                ->toArray();
            
            // Combine both lists of users to exclude
            $excludedUserIds = array_unique(array_merge($blockedUserIds, $usersWhoBlockedMe));
            
            $this->posts = Post::whereNotIn('user_id', $excludedUserIds)
                ->latest()
                ->get();
        } else {
            $this->posts = Post::latest()->get();
        }
    }

    private function shouldHidePost(Post $post): bool
    {
        if (!auth()->check()) {
            return false;
        }
        
        // Check if current user has blocked the post author
        $hasBlocked = Block::where('blocker_id', auth()->id())
            ->where('blocked_id', $post->user_id)
            ->exists();
        
        // Check if post author has blocked current user
        $isBlockedBy = Block::where('blocker_id', $post->user_id)
            ->where('blocked_id', auth()->id())
            ->exists();
        
        return $hasBlocked || $isBlockedBy;
    }

   public function render()
    {
        // $posts = Post::with(['user', 'media'])
        //     ->latest()
        //     ->get();

        return view('livewire.home');
    }

    #[On('post-deleted')]
    function postDeleted($id)
    {
        $this->posts = $this->posts->filter(fn($post) => $post->id !== $id);
    }
}

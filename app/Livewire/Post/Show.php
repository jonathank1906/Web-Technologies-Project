<?php

namespace App\Livewire\Post;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Block;
use Livewire\Component;

class Show extends Component
{
    public Post $post;
    public string $body = '';
    public $parent_id = null;

    protected $rules = [
        'body' => 'required|min:1|max:500'
    ];

    function addComment()
    {
        $this->validate();

        # Create comment
        Comment::create([
            'body' => $this->body,
            'parent_id' => $this->parent_id,
            'commentable_id' => $this->post->id,
            'commentable_type' => Post::class,
            'user_id' => auth()->id(),
        ]);

        $this->reset('body', 'parent_id');

        // Refresh the post with relationships
        $this->post = $this->post->fresh(['user', 'media', 'comments.user'])->loadCount('likes', 'comments');
    }

    function setParent(Comment $comment)
    {
        $this->parent_id = $comment->id;
        $this->body = "@" . $comment->user->name . " ";
        $this->post = $this->post->fresh(['user', 'media', 'comments.user'])->loadCount('likes', 'comments');
    }

    public function mount(Post $post)
    {
        $this->post = $post->load(['user', 'media', 'comments.user'])->loadCount('likes', 'comments');
    }

    public function render()
    {
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
            
            $comments = $this->post->comments()
                ->whereNull('parent_id')
                ->whereNotIn('user_id', $excludedUserIds)
                ->with(['user', 'replies' => function ($query) use ($excludedUserIds) {
                    $query->whereNotIn('user_id', $excludedUserIds)->with('user');
                }])
                ->get();

            // Calculate filtered like count (excluding likes from blocked users)
            $filteredLikeCount = $this->post->likes()
                ->whereNotIn('user_id', $excludedUserIds)
                ->count();

            // Calculate filtered comment count (excluding comments from blocked users)
            $filteredCommentCount = $this->post->comments()
                ->whereNotIn('user_id', $excludedUserIds)
                ->count();
        } else {
            $comments = $this->post->comments()
                ->whereNull('parent_id')
                ->with(['user', 'replies.user'])
                ->get();

            $filteredLikeCount = $this->post->likes()->count();
            $filteredCommentCount = $this->post->comments()->count();
        }

        return view('livewire.post.show', [
            'comments' => $comments,
            'filteredLikeCount' => $filteredLikeCount,
            'filteredCommentCount' => $filteredCommentCount
        ]);
    }

    function toggleCommentLike(Comment $comment)
    {
        abort_unless(auth()->check(), 401);

        // Prevent users from liking their own comments
        if ($comment->user_id === auth()->id()) {
            return;
        }

        auth()->user()->toggleLike($comment);

        // Refresh the post with updated relationships
        $this->post = $this->post->fresh(['user', 'media', 'comments.user'])->loadCount('likes', 'comments');
    }
}

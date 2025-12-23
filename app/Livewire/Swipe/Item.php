<?php

namespace App\Livewire\Swipe;
use App\Models\User;
use App\Models\Block;

use Livewire\Component;

class Item extends Component
{
    public $users;

    public function mount()
    {
        $authUser = auth()->user();
        // Exclude users already followed
        $alreadyFollowingIds = $authUser->following()->pluck('users.id')->toArray();
        
        // Exclude users that current user has blocked
        $blockedUserIds = Block::where('blocker_id', $authUser->id)
            ->pluck('blocked_id')
            ->toArray();
        
        // Exclude users who have blocked current user
        $usersWhoBlockedMe = Block::where('blocked_id', $authUser->id)
            ->pluck('blocker_id')
            ->toArray();
        
        // Combine all excluded user IDs
        $excludedIds = array_unique(array_merge($alreadyFollowingIds, $blockedUserIds, $usersWhoBlockedMe));
        
        $this->users = User::where('id', '<>', $authUser->id)
            ->whereNotIn('id', $excludedIds)
            ->get();
    }

    public function follow($userId)
    {
        $authUser = auth()->user();
        $user = User::findOrFail($userId);
        $authUser->follow($user);
        // Remove user from swipe list
        $this->users = $this->users->filter(fn($u) => $u->id !== $userId);
    }

    public function render()
    {
        return view('livewire.swipe.item', ['users' => $this->users]);
    }
}
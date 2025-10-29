<?php

namespace App\Livewire\Connections;

use Livewire\Component;
use App\Models\User;
use App\Models\Connection;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $query = '';

    public function getUsersProperty()
    {
        $me = Auth::user();

        return User::query()
            ->where('id', '!=', $me->id)
            ->where(function ($q) {
                $q->where('name', 'like', '%' . $this->query . '%')
                  ->orWhere('email', 'like', '%' . $this->query . '%');
            })
            ->orderBy('name')
            ->get();
    }

    public function getPendingProperty()
    {
        return Auth::user()->pendingRequests();
    }

    public function sendRequest(int $userId)
    {
        $me = Auth::user();

        if ($me->id === $userId) return;

        // avoid duplicate
        Connection::updateOrCreate([
            'sender_id' => $me->id,
            'receiver_id' => $userId,
        ], [
            'status' => 'pending',
        ]);
    }

    public function acceptRequest(int $connectionId)
    {
        $conn = Connection::find($connectionId);
        if (!$conn) return;
        if ($conn->receiver_id !== Auth::id()) return;
        $conn->update(['status' => 'accepted']);
    }

    public function declineRequest(int $connectionId)
    {
        $conn = Connection::find($connectionId);
        if (!$conn) return;
        if ($conn->receiver_id !== Auth::id()) return;
        $conn->update(['status' => 'declined']);
    }
    public function render()
    {
        return view('livewire.connections.index');
    }
}

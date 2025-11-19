<?php

namespace App\Livewire\Messages;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;

class Index extends Component
{
    use WithFileUploads;
    #[Url]
    public ?int $userId = null; // chatting with
    public string $body = '';
    public $attachment = null;
    public string $search = '';  // Add search property for filtering friends
    public ?int $selectedMessageIndex = null;
    public ?int $editingMessageIndex = null;
    public string $editingText = '';
    public bool $showDeleteModal = false;
    public string $newMessage = '';


    public function getChatPartnerProperty(): ?User
    {
        if (!$this->userId) {
            return null;
        }
        return User::query()->find($this->userId);
    }

    public function updatedUserId(): void
    {
        // when the chat partner changes, mark incoming messages as read
        if (!$this->chatPartner) return;

        \App\Models\Message::query()
            ->where('sender_id', $this->chatPartner->id)
            ->where('receiver_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    public function unreadCount(int $userId): int
    {
        return \App\Models\Message::query()
            ->where('sender_id', $userId)
            ->where('receiver_id', Auth::id())
            ->whereNull('read_at')
            ->count();
    }

    public function getMessagesProperty()
    {
        if (!$this->chatPartner) {
            return collect();
        }

        $me = Auth::user();

        return Message::query()
            ->where(function ($q) use ($me) {
                $q->where('sender_id', $me->id)
                  ->where('receiver_id', $this->chatPartner->id);
            })
            ->orWhere(function ($q) use ($me) {
                $q->where('sender_id', $this->chatPartner->id)
                  ->where('receiver_id', $me->id);
            })
            ->orderBy('created_at')
            ->get();
    }

    public function getFriendsProperty()
    {
        $me = Auth::user();
        return $me->getConnections();
    }

    public function getFilteredFriendsProperty()
    {
        return $this->friends
            ->filter(function ($friend) {
                return empty($this->search) || 
                       str_contains(strtolower($friend->name), strtolower($this->search));
            })
            ->map(function ($friend) {
                return $this->transformFriendData($friend);
            });
    }

    public function getActiveFriendProperty()
    {
        if (!$this->userId) {
            return null;
        }
        $friend = $this->friends->firstWhere('id', $this->userId);
        return $friend ? $this->transformFriendData($friend) : null;
    }

    protected function transformFriendData($friend)
    {
        return [
            'id' => $friend->id,
            'name' => $friend->name,
            'img' => strtoupper(substr($friend->name, 0, 1)), // First letter of name
            'flag' => $friend->getFlagPictureUrl(),
            'unread' => $this->unreadCount($friend->id),
            'lang' => 'English', // Default language
            'messages' => $friend->id === $this->userId ? $this->messages->map(function($msg) {
                return [
                    'text' => $msg->body,
                    'from_me' => $msg->sender_id === auth()->id()
                ];
            })->toArray() : []
        ];
    }

    public function selectFriend(int $friendId): void
    {
        $this->userId = $friendId;
    }

    public function send(): void
    {
        \Log::info('Livewire Messages\Index::send called', ['user_id' => Auth::id(), 'chat_partner' => $this->userId]);
        
        $this->validate([
            'newMessage' => ['required', 'string', 'max:2000'],
            'attachment' => ['nullable', 'file', 'max:10240', 'mimes:png,jpg,jpeg,gif,webp,mp3,wav,ogg'],
        ]);

        if (!$this->chatPartner) {
            return;
        }

        $me = Auth::user();

        $data = [
            'sender_id' => $me->id,
            'receiver_id' => $this->chatPartner->id,
            'body' => $this->newMessage,
        ];

        if ($this->attachment) {
            $path = $this->attachment->store('messages', 'public');
            $mime = $this->attachment->getClientMimeType();
            $type = str_contains($mime, 'image') ? 'image' : (str_contains($mime, 'audio') ? 'audio' : 'file');
            $data['attachment_path'] = $path;
            $data['attachment_type'] = $type;
            $data['attachment_meta'] = ['mime' => $mime, 'size' => $this->attachment->getSize()];
        }

        Message::create($data);

        // Clear the message
        $this->newMessage = '';
        $this->attachment = null;
        
        // Dispatch Alpine.js event to clear the input
        $this->js("window.dispatchEvent(new Event('message-sent'))");
    }


    public function clearChat(): void
    {
        if (!$this->chatPartner) return;
        $me = Auth::user();
        // Delete all messages between the two users
        Message::query()
            ->where(function ($q) use ($me) {
                $q->where('sender_id', $me->id)
                  ->where('receiver_id', $this->chatPartner->id);
            })
            ->orWhere(function ($q) use ($me) {
                $q->where('sender_id', $this->chatPartner->id)
                  ->where('receiver_id', $me->id);
            })
            ->delete();
    }

    public function selectMessage(int $index): void
    {
        $this->selectedMessageIndex = $index;
    }

    public function startEdit(int $index): void
    {
        $this->editingMessageIndex = $index;
        $messages = $this->messages;
        if ($messages->has($index)) {
            $this->editingText = $messages[$index]->body;
        }
    }

    public function saveEdit(): void
    {
        if ($this->editingMessageIndex === null) return;
        
        $messages = $this->messages;
        if ($messages->has($this->editingMessageIndex)) {
            $message = $messages[$this->editingMessageIndex];
            Message::where('id', $message->id)->update(['body' => $this->editingText]);
        }
        
        // Clear editing state
        $this->editingText = '';
        $this->editingMessageIndex = null;
        $this->selectedMessageIndex = null;
    }


    public function cancelEdit(): void
    {
        $this->editingMessageIndex = null;
        $this->editingText = '';
    }
    public function refreshMessages(): void
    {
        // Just trigger Livewire to re-render messages
        $this->dispatch('$refresh');
    }

    public function confirmDelete(int $index): void
    {
        $this->selectedMessageIndex = $index;
        $this->showDeleteModal = true;
    }

    public function cancelDelete(): void
    {
        $this->showDeleteModal = false;
        $this->selectedMessageIndex = null;
    }

    public function deleteMessage(): void
    {
        if ($this->selectedMessageIndex === null) return;
        
        $messages = $this->messages;
        if ($messages->has($this->selectedMessageIndex)) {
            $message = $messages[$this->selectedMessageIndex];
            Message::where('id', $message->id)->delete();
    
            // Remove from UI instantly
            $messages->forget($this->selectedMessageIndex);
        }
    
        $this->showDeleteModal = false;
        $this->selectedMessageIndex = null;
    }

    public function render()
    {
        return view('livewire.messages.index', [
            'activeFriend' => $this->activeFriend,
            'filteredFriends' => $this->filteredFriends
        ]);
    }
}



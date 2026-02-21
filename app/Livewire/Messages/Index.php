<?php

namespace App\Livewire\Messages;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    protected $listeners = ['updateStatus'];

    #[Url]
    public ?int $userId = null;

    public string $body = '';

    public $attachment = null;

    public string $search = '';

    public ?int $selectedMessageId = null;

    public ?int $editingMessageId = null;

    public string $editingText = '';

    public bool $showDeleteModal = false;

    public string $newMessage = '';

    public array $friendStatuses = [];

    public function getChatPartnerProperty(): ?User
    {
        if (! $this->userId) {
            return null;
        }

        return User::query()->find($this->userId);
    }

    public function updatedUserId(): void
    {
        if (! $this->chatPartner) {
            return;
        }

        Message::query()
            ->where('sender_id', $this->chatPartner->id)
            ->where('receiver_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $this->cancelEdit();
        $this->cancelDelete();
    }

    public function unreadCount(int $userId): int
    {
        return Message::query()
            ->where('sender_id', $userId)
            ->where('receiver_id', Auth::id())
            ->whereNull('read_at')
            ->count();
    }

    public function getMessagesProperty()
    {
        if (! $this->chatPartner) {
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
        if (! $this->userId) {
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
            'img' => strtoupper(substr($friend->name, 0, 1)),
            'flag' => $friend->getFlagPictureUrl(),
            'unread' => $this->unreadCount($friend->id),
            'lang' => 'English',
            'status' => $this->friendStatuses[$friend->id] ?? 'Offline',
            'messages' => $friend->id === $this->userId ? $this->messages->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'text' => $msg->body,
                    'from_me' => $msg->sender_id === auth()->id(),
                ];
            })->toArray() : [],
        ];
    }

    public function selectFriend(int $friendId): void
    {
        $this->userId = $friendId;
    }

    public function handleSubmit(): void
    {
        if ($this->editingMessageId) {
            $this->saveEdit();
        } else {
            $this->send();
        }
    }

    public function send(): void
    {
        $this->validate([
            'newMessage' => ['required', 'string', 'max:2000'],
            'attachment' => ['nullable', 'file', 'max:10240', 'mimes:png,jpg,jpeg,gif,webp,mp3,wav,ogg'],
        ]);

        if (! $this->chatPartner) {
            return;
        }

        $data = [
            'sender_id' => Auth::id(),
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

        $this->newMessage = '';
        $this->attachment = null;

        $this->js("window.dispatchEvent(new Event('message-sent'))");
    }

    public function selectMessage(int $messageId): void
    {
        $this->selectedMessageId = $messageId;
    }

    public function startEdit(int $messageId): void
    {
        $this->editingMessageId = $messageId;

        $message = Message::find($messageId);

        if ($message && $message->sender_id === Auth::id()) {
            $this->editingText = $message->body;
        }
    }

    public function saveEdit(): void
    {
        if (! $this->editingMessageId) {
            return;
        }

        $message = Message::find($this->editingMessageId);

        if ($message && $message->sender_id === Auth::id()) {
            $message->update(['body' => $this->editingText]);
        }

        $this->cancelEdit();
    }

    public function cancelEdit(): void
    {
        $this->editingMessageId = null;
        $this->editingText = '';
        $this->selectedMessageId = null;
    }

    public function refreshMessages(): void
    {
        $this->dispatch('$refresh');
    }

    public function confirmDelete(int $messageId): void
    {
        $this->selectedMessageId = $messageId;
        $this->showDeleteModal = true;
    }

    public function cancelDelete(): void
    {
        $this->showDeleteModal = false;
        $this->selectedMessageId = null;
    }

    public function deleteMessage(): void
    {
        if (! $this->selectedMessageId) {
            return;
        }

        Message::where('id', $this->selectedMessageId)
            ->where('sender_id', Auth::id())
            ->delete();

        $this->showDeleteModal = false;
        $this->selectedMessageId = null;
    }

    public function updateStatus($data)
    {
        foreach ($data as $userId => $status) {
            $this->friendStatuses[$userId] = $status;
        }
    }

    public function render()
    {
        return view('livewire.messages.index', [
            'activeFriend' => $this->activeFriend,
            'filteredFriends' => $this->filteredFriends
        ]);
    }
}
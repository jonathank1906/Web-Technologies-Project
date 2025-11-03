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

        return $me->friends();
    }

    public function send(): void
    {
        \Log::info('Livewire Messages\Index::send called', ['user_id' => Auth::id(), 'chat_partner' => $this->userId]);
        $this->validate([
            'body' => ['nullable', 'string', 'max:2000'],
            'attachment' => ['nullable', 'file', 'max:10240', 'mimes:png,jpg,jpeg,gif,webp,mp3,wav,ogg'],
        ]);

        if (!$this->chatPartner) {
            return;
        }

        $me = Auth::user();

        $data = [
            'sender_id' => $me->id,
            'receiver_id' => $this->chatPartner->id,
            'body' => $this->body,
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

        $this->body = '';
        $this->attachment = null;
        // Dispatch a Livewire browser event (Livewire v3 uses $this->dispatch())
        $this->dispatch('messageSent', [
            'from' => $me->id,
            'to' => $this->chatPartner->id,
        ]);
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

    public function render()
    {
        

        return view('livewire.messages.index');
    }
}

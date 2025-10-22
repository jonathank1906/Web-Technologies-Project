<?php

namespace App\Livewire\Messages;

use Livewire\Component;

class Index extends Component
{
    public string $search = '';
    public ?int $activeFriendId = null;
    public array $activeFriend = [];
    public string $newMessage = '';
    public ?int $selectedMessageIndex = null;
    public ?int $editingMessageIndex = null;
    public string $editingText = '';
    public bool $showDeleteModal = false;
    public ?int $deleteMessageIndex = null;

    public array $friends = [
        [
            'id' => 1, 'name' => 'Jonathan', 'flag' => 'us', 'img' => '🧔', 'lang' => 'EN <-> ES',
            'messages' => [
                ['text' => 'Hey! You ready to chat?', 'from_me' => false],
                ['text' => 'Yes, I am ready!', 'from_me' => true],
            ],
        ],
        [
            'id' => 2, 'name' => 'Lukas', 'flag' => 'de', 'img' => '👨‍🦱', 'lang' => 'DE <-> FR',
            'messages' => [['text' => 'I sent you a message yesterday.', 'from_me' => false]],
        ],
        [
            'id' => 3, 'name' => 'Deivid', 'flag' => 'br', 'img' => '🧒', 'lang' => 'PT <-> EN',
            'messages' => [['text' => 'Let’s learn together!', 'from_me' => false]],
        ],
        [
            'id' => 4, 'name' => 'Benjamin', 'flag' => 'fr', 'img' => '👨‍🦰', 'lang' => 'FR <-> DE',
            'messages' => [['text' => 'Bonjour! Ça va?', 'from_me' => false]],
        ],
        [
            'id' => 5, 'name' => 'Daniils', 'flag' => 'lv', 'img' => '🧑', 'lang' => 'LV <-> EN',
            'messages' => [
                ['text' => 'See you later!', 'from_me' => false],
                ['text' => 'Sure let’s do it!', 'from_me' => true],
            ],
        ],
        [
            'id' => 6, 'name' => 'Azzam', 'flag' => 'id', 'img' => '👳', 'lang' => 'ID <-> EN',
            'messages' => [
                ['text' => 'Apakah kamu bisa bantu saya?', 'from_me' => false],
                ['text' => 'Tentu saja, ayo mulai.', 'from_me' => true],
            ],
        ],
        [
            'id' => 7, 'name' => 'Kryszhtof', 'flag' => 'pl', 'img' => '👨‍🔧', 'lang' => 'PL <-> EN',
            'messages' => [
                ['text' => 'Do you want to meet tomorrow?', 'from_me' => false],
                ['text' => 'Yes, I’ll be ready.', 'from_me' => true],
            ],
        ],
    ];

    public function selectFriend($id)
    {
        $this->activeFriendId = $id;
        $this->activeFriend = collect($this->friends)->firstWhere('id', $id);
        $this->reset('newMessage', 'editingText', 'editingMessageIndex', 'selectedMessageIndex', 'showDeleteModal');
        $this->dispatch('scroll-to-bottom');
    }

    private function updateActiveFriend()
    {
        foreach ($this->friends as &$friend) {
            if ($friend['id'] === $this->activeFriend['id']) {
                $friend = $this->activeFriend;
                break;
            }
        }
    }

    public function sendMessage()
    {
        if (!$this->activeFriendId || trim($this->newMessage) === '') return;

        $this->activeFriend['messages'][] = [
            'text' => $this->newMessage,
            'from_me' => true,
        ];

        $this->newMessage = '';
        $this->updateActiveFriend();
        $this->dispatch('scroll-to-bottom');
    }

    public function selectMessage($index)
    {
        $this->selectedMessageIndex = $index;
    }

    public function startEdit($index)
    {
        $msg = $this->activeFriend['messages'][$index];
        if (!$msg['from_me']) return;

        $this->editingMessageIndex = $index;
        $this->editingText = $msg['text'];
    }

    public function saveEdit()
{
    if (is_null($this->editingMessageIndex)) return;

    $index = $this->editingMessageIndex;

    // ✅ reassign the whole message item (not nested mutation)
    $this->activeFriend['messages'][$index] = [
        'text' => $this->editingText,
        'from_me' => true,
    ];

    $this->updateActiveFriend();
    $this->cancelEdit();
    $this->dispatch('scroll-to-bottom');
}


    public function cancelEdit()
    {
        $this->editingMessageIndex = null;
        $this->editingText = '';
    }

    public function confirmDelete($index)
    {
        $msg = $this->activeFriend['messages'][$index];
        if (!$msg['from_me']) return;

        $this->deleteMessageIndex = $index;
        $this->showDeleteModal = true;
    }

    public function deleteMessage()
    {
        if (is_null($this->deleteMessageIndex)) return;

        unset($this->activeFriend['messages'][$this->deleteMessageIndex]);
        $this->activeFriend['messages'] = array_values($this->activeFriend['messages']);
        $this->cancelDelete();
        $this->updateActiveFriend();
        $this->dispatch('scroll-to-bottom');
    }

    public function cancelDelete()
    {
        $this->deleteMessageIndex = null;
        $this->showDeleteModal = false;
    }

    public function getFilteredFriendsProperty()
    {
        $search = strtolower($this->search);
        return collect($this->friends)
            ->filter(fn($friend) => str_contains(strtolower($friend['name']), $search))
            ->values()
            ->all();
    }

    public function render()
    {
        

        return view('livewire.messages.index');
    }
}

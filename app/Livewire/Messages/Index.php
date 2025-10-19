<?php

namespace App\Livewire\Messages;

use Livewire\Component;

class Index extends Component
{
    public string $search = '';
    public $activeFriend = null;
    public string $newMessage = '';
    public ?int $selectedMessageIndex = null;
    public ?int $editingMessageIndex = null;
    public string $editingText = '';
    public bool $showDeleteModal = false;
    public ?int $deleteMessageIndex = null;

    public array $friends = [
        [
            'id' => 1,
            'name' => 'Jonathan',
            'flag' => 'us',
            'img' => '🧔',
            'lang' => 'EN <-> ES',
            'messages' => [
                ['text' => 'Hey! You ready to chat?', 'from_me' => false],
                ['text' => 'Yes, I am ready!', 'from_me' => true],
            ],
        ],
        [
            'id' => 2,
            'name' => 'Lukas',
            'flag' => 'de',
            'img' => '👨‍🦱',
            'lang' => 'DE <-> FR',
            'messages' => [
                ['text' => 'I sent you a message yesterday.', 'from_me' => false],
            ],
        ],
        [
            'id' => 3,
            'name' => 'Deivid',
            'flag' => 'br',
            'img' => '🧒',
            'lang' => 'PT <-> EN',
            'messages' => [
                ['text' => 'Let’s learn together!', 'from_me' => false],
            ],
        ],
        [
            'id' => 4,
            'name' => 'Benjamin',
            'flag' => 'fr',
            'img' => '👨‍🦰',
            'lang' => 'FR <-> DE',
            'messages' => [
                ['text' => 'Bonjour! Ça va?', 'from_me' => false],
            ],
        ],
        [
            'id' => 5,
            'name' => 'Daniils',
            'flag' => 'lv',
            'img' => '🧑',
            'lang' => 'LV <-> EN',
            'messages' => [
                ['text' => 'See you later!', 'from_me' => false],
                ['text' => 'Sure let’s do it!', 'from_me' => true],
            ],
        ],
    ];

    // select a friend
    public function selectFriend($id)
    {
        $this->activeFriend = collect($this->friends)->firstWhere('id', $id);
        $this->reset('newMessage', 'editingText', 'editingMessageIndex', 'selectedMessageIndex', 'showDeleteModal');
    }

    // ✅ update main friends array with modified activeFriend
    private function updateActiveFriend()
    {
        if (!$this->activeFriend) return;

        foreach ($this->friends as &$friend) {
            if ($friend['id'] === $this->activeFriend['id']) {
                $friend = $this->activeFriend;
                break;
            }
        }
    }

    // ✅ send new message
    public function sendMessage()
    {
        if (!$this->activeFriend || trim($this->newMessage) === '') return;

        $this->activeFriend['messages'][] = [
            'text' => $this->newMessage,
            'from_me' => true,
        ];

        $this->newMessage = '';
        $this->updateActiveFriend();
    }

    // select message (to highlight/edit/delete)
    public function selectMessage($index)
    {
        $this->selectedMessageIndex = $index;
    }

    // start editing (only your message)
    public function startEdit($index)
    {
        $msg = $this->activeFriend['messages'][$index];
        if (!$msg['from_me']) return;

        $this->editingMessageIndex = $index;
        $this->editingText = $msg['text'];
    }

    // ✅ save edited message
    public function saveEdit()
    {
        if (is_null($this->editingMessageIndex)) return;

        $this->activeFriend['messages'][$this->editingMessageIndex]['text'] = $this->editingText;
        $this->cancelEdit();
        $this->updateActiveFriend();
    }

    public function cancelEdit()
    {
        $this->editingMessageIndex = null;
        $this->editingText = '';
    }

    // confirm delete (only for your messages)
    public function confirmDelete($index)
    {
        $msg = $this->activeFriend['messages'][$index];
        if (!$msg['from_me']) return;

        $this->deleteMessageIndex = $index;
        $this->showDeleteModal = true;
    }

    // ✅ delete message
    public function deleteMessage()
    {
        if (is_null($this->deleteMessageIndex)) return;

        unset($this->activeFriend['messages'][$this->deleteMessageIndex]);
        $this->activeFriend['messages'] = array_values($this->activeFriend['messages']);
        $this->cancelDelete();
        $this->updateActiveFriend();
    }

    public function cancelDelete()
    {
        $this->deleteMessageIndex = null;
        $this->showDeleteModal = false;
    }

    // filter friends (live)
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

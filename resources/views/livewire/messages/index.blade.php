<div class="flex h-screen bg-[#f0f2f5] text-gray-800 font-sans">
    <!-- Left Column: Friends List -->
    <div class="w-1/3 bg-[#ffeaea] border-r border-gray-300 flex flex-col">
        <!-- Search Bar -->
        <div class="p-4 border-b border-gray-300 relative">
            <input type="text"
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                placeholder="Search friends..." />
        </div>

        <!-- Friends List -->
        <div class="flex-1 overflow-y-auto px-4 pt-2 space-y-4">
            @foreach ($this->friends as $friend)
                <a href="{{ route('messages', ['userId' => $friend->id]) }}"
                   class="flex items-start gap-3 p-3 bg-white rounded-lg hover:bg-yellow-100 cursor-pointer transition shadow-sm">
                    <div class="relative w-12 h-12 flex items-center justify-center text-2xl bg-white rounded-full shadow">
                        <span>{{ strtoupper(substr($friend->name, 0, 1)) }}</span>
                    </div>
                    <div class="flex flex-col text-sm">
                        <div class="flex items-center gap-2">
                            <span class="font-semibold text-gray-900 text-base">{{ $friend->name }}</span>
                            @php($unread = $this->unreadCount($friend->id))
                            @if($unread > 0)
                                <span class="text-xs bg-red-500 text-white px-2 py-0.5 rounded">{{ $unread }}</span>
                            @endif
                        </div>
                        <span class="text-xs text-gray-600 italic">&nbsp;</span>
                        <span class="text-xs text-gray-500 mt-1 truncate">&nbsp;</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Right Column: Chat Window -->
    <div class="w-2/3 flex flex-col">
        <!-- Chat Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-white shadow-sm">
            <div class="flex items-center gap-3">
                <div class="relative w-10 h-10 flex items-center justify-center text-xl bg-white rounded-full shadow">
                    <span>
                        {{ $this->chatPartner ? strtoupper(substr($this->chatPartner->name, 0, 1)) : '👤' }}
                    </span>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-gray-800">
                        {{ $this->chatPartner?->name ?? 'Select a user' }}
                    </h2>
                    <p class="text-xs text-gray-500">&nbsp;</p>
                </div>
            </div>

            <!-- Header Icons -->
            <div class="flex items-center gap-4 text-gray-600">
                <button title="Voice Call">
                    <i class="fas fa-phone-alt hover:text-green-600 transition"></i>
                </button>
                <button title="More Options">
                    <i class="fas fa-ellipsis-v hover:text-gray-800 transition"></i>
                </button>
                @if($this->chatPartner)
                <button title="Clear Chat" wire:click="clearChat" class="ml-2 px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-xs">Clear Chat</button>
                @endif
            </div>
        </div>

    <!-- Chat Messages (polled) -->
    <div wire:poll.visible.1500ms class="flex-1 overflow-y-auto px-6 py-4 space-y-3 bg-[#f5f6f8]">
            @php($me = auth()->user())
            @foreach ($this->messages as $message)
                @if ($message->sender_id === $me->id)
                    <div class="bg-blue-500 text-white p-3 rounded max-w-sm self-end ml-auto">
                        @if($message->attachment_path && $message->attachment_type === 'image')
                            <img src="{{ asset('storage/' . $message->attachment_path) }}" class="max-w-xs rounded mb-2" alt="image" />
                        @elseif($message->attachment_path && $message->attachment_type === 'audio')
                            <audio controls class="w-full mb-2">
                                <source src="{{ asset('storage/' . $message->attachment_path) }}" type="{{ $message->attachment_meta['mime'] ?? 'audio/mpeg' }}">
                                Your browser does not support the audio element.
                            </audio>
                        @endif
                        {{ $message->body }}
                    </div>
                @else
                    <div class="bg-gray-200 p-3 rounded max-w-sm">
                        @if($message->attachment_path && $message->attachment_type === 'image')
                            <img src="{{ asset('storage/' . $message->attachment_path) }}" class="max-w-xs rounded mb-2" alt="image" />
                        @elseif($message->attachment_path && $message->attachment_type === 'audio')
                            <audio controls class="w-full mb-2">
                                <source src="{{ asset('storage/' . $message->attachment_path) }}" type="{{ $message->attachment_meta['mime'] ?? 'audio/mpeg' }}">
                                Your browser does not support the audio element.
                            </audio>
                        @endif
                        {{ $message->body }}
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Message Input -->
        <form wire:submit.prevent="send" class="px-6 py-4 border-t bg-white flex items-center gap-3">
            <button title="Emoji">
                <i class="far fa-smile text-gray-500 text-lg hover:text-yellow-500"></i>
            </button>
            <button title="Microphone">
                <i class="fas fa-microphone text-gray-500 text-lg hover:text-red-500"></i>
            </button>
            <button title="Attach File">
                <i class="fas fa-paperclip text-gray-500 text-lg hover:text-blue-500"></i>
            </button>
            <input type="text"
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                placeholder="Type a message..." wire:model.defer="body" />
            <input type="file" wire:model="attachment" accept="image/*,audio/*" class="ml-2" />
            <button type="submit" wire:click="send" class="shrink-0 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Send</button>
        </form>
    </div>
</div>

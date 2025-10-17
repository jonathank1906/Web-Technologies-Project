<div class="flex h-screen bg-[#f0f2f5] text-gray-800 font-sans">
    <!-- Left Column: Friends List -->
    <div class="w-1/3 bg-[#ffeaea] border-r border-gray-300 flex flex-col">
        <!-- Search Bar -->
        <div class="p-4 border-b border-gray-300 relative">
            <input type="text"
                wire:model="search"
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                placeholder="Search friends..." />
            <x-tabler-plus class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 w-5 h-5"/>
        </div>

        <!-- Friends List -->
        <div class="flex-1 overflow-y-auto px-4 pt-2 space-y-4">
            @foreach ($this->filteredFriends as $friend)
                <div
                    wire:click="selectFriend({{ $friend['id'] }})"
                    class="flex items-start gap-3 p-3 bg-white rounded-lg hover:bg-yellow-100 cursor-pointer transition shadow-sm">
                    
                    <!-- Avatar -->
                    <div class="relative w-12 h-12 flex items-center justify-center text-2xl bg-white rounded-full shadow">
                        <span>{{ $friend['img'] }}</span>
                        <img src="/flags/{{ $friend['flag'] }}.png" alt="{{ strtoupper($friend['flag']) }}"
                             class="absolute bottom-0 right-0 w-4 h-4 rounded-full border border-white" />
                    </div>

                    <!-- Text Info -->
                    <div class="flex flex-col text-sm">
                        <span class="font-semibold text-gray-900 text-base">{{ $friend['name'] }}</span>
                        <span class="text-xs text-gray-600 italic">{{ $friend['lang'] }}</span>
                        <span class="text-xs text-gray-500 mt-1 truncate">
                            {{ \Illuminate\Support\Str::limit(last($friend['messages']), 13, '...') }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Right Column: Chat Window -->
    <div class="w-2/3 flex flex-col">
        @if ($activeFriend)
            <!-- Chat Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-white shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="relative w-10 h-10 flex items-center justify-center text-xl bg-white rounded-full shadow">
                        <span>{{ $activeFriend['img'] }}</span>
                        <img src="/flags/{{ $activeFriend['flag'] }}.png" alt="{{ strtoupper($activeFriend['flag']) }}"
                             class="absolute bottom-0 right-0 w-4 h-4 rounded-full border border-white" />
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-gray-800">{{ $activeFriend['name'] }}</h2>
                        <p class="text-xs text-gray-500">{{ $activeFriend['lang'] }}</p>
                    </div>
                </div>

                <!-- Header Icons -->
                <div class="flex items-center gap-4 text-gray-600">
                    <button title="Voice Call">
                        <x-tabler-phone class="w-5 h-5 hover:text-green-600 transition" />
                    </button>
                    <button title="More Options">
                        <x-tabler-dots-vertical class="w-5 h-5 hover:text-gray-800 transition" />
                    </button>
                </div>
            </div>

            <!-- Chat Messages -->
            <div class="flex-1 overflow-y-auto px-6 py-4 space-y-3 bg-[#f5f6f8]">
                @foreach ($activeFriend['messages'] as $i => $message)
                    <div class="{{ $i % 2 == 0 ? 'bg-gray-200' : 'bg-blue-500 text-white self-end ml-auto' }} p-3 rounded max-w-sm">
                        {{ $message }}
                    </div>
                @endforeach
            </div>

            <!-- Message Input -->
            <div class="px-6 py-4 border-t bg-white flex items-center gap-3">
                <x-tabler-mood-smile class="w-5 h-5 text-gray-500 hover:text-yellow-500" />
                <x-tabler-microphone class="w-5 h-5 text-gray-500 hover:text-red-500" />
                <x-tabler-paperclip class="w-5 h-5 text-gray-500 hover:text-blue-500" />
                <input type="text"
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                    placeholder="Type a message..." />
                <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Send</button>
            </div>
        @else
            <div class="flex-1 flex items-center justify-center text-gray-400">
                <p>Select a friend to start chatting.</p>
            </div>
        @endif
    </div>
</div>

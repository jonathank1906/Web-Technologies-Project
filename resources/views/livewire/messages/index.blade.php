<div class="flex h-screen bg-base-200 text-base-content font-sans relative items-stretch overflow-hidden">
    <!-- Friend List -->
    <div class="w-1/3 bg-base-100 border-r border-base-300 flex flex-col h-full">
        <!-- Search Bar -->
        <div class="p-4">
            <div class="relative">
                <x-tabler-search
                        class="text-gray-600 dark:text-gray-400 absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 pointer-events-none" />
                <input type="text"
                    wire:model.live.debounce.300ms="search"
                    class="w-full pl-10 pr-4 py-2 border-gray-400/30 dark:border-gray-500 bg-base-100 rounded-lg focus:outline-none focus:ring-indigo-600"
                    placeholder="Search friends..." />
            </div>
        </div>
       
        <!-- Friends -->
        <div class="flex-1 overflow-y-auto px-4 pt-2 space-y-4">
            @forelse ($this->filteredFriends as $friend)
                <div wire:key="friend-{{ $friend['id'] }}"
                    wire:click="selectFriend({{ $friend['id'] }})"
                    wire:loading.class="opacity-50"
                    class="flex items-start gap-3 p-3 bg-base-100 rounded-lg cursor-pointer shadow-sm transition duration-150 ease-out hover:bg-gray-500/10">
                    <div class="relative w-12 h-12 flex items-center justify-center text-2xl bg-indigo-600 rounded-full shadow">
                        <span>{{ $friend['img'] }}</span>
                        <img src="{{ $friend['flag'] }}"
                        class="absolute bottom-0 right-0 w-4 h-4 object-cover rounded-full border border-base-100 shadow" />
                    </div>

                    <div class="flex flex-col text-sm">
                        <span class="font-semibold text-base-content text-base">{{ $friend['name'] }}</span>
                        <span class="text-xs text-base-content italic">{{ $friend['lang'] }}</span>
                        <span class="text-xs text-base-content mt-1 truncate">
                            {{ \Illuminate\Support\Str::limit(last($friend['messages'])['text'] ?? '', 13, '...') }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="text-center text-base-content mt-6">No results found</div>
            @endforelse
        </div> 
    </div> 
    <!-- Chat Column -->
    <div class="w-2/3 flex flex-col relative h-full min-h-0">
        <!-- Spinner -->
        <div wire:loading.target="selectFriend,send" wire:loading.flex class="absolute inset-0 bg-opacity-50 justify-center items-center z-50">
            <x-tabler-loader-2 class="animate-spin w-6 h-6 text-base-content" />
        </div>

        @if ($activeFriend)
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-base-300 bg-base-100 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="relative w-10 h-10 flex items-center justify-center text-xl bg-indigo-600 rounded-full shadow">
                        <span>{{ $activeFriend['img'] }}</span>
                        <img src="{{ $friend['flag'] }}"
                             class="absolute bottom-0 right-0 w-4 h-4 rounded-full border border-base-100" />
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-base-content">{{ $activeFriend['name'] }}</h2>
                        <p class="text-xs text-base-content">{{ $activeFriend['lang'] }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 text-base-content">
                    <x-tabler-dots-vertical class="w-5 h-5 hover:text-base-content transition" />
                </div>
            </div>

            <!-- Messages -->
            <div x-chat-scroll class="flex-1 overflow-y-auto px-6 py-4 space-y-3 bg-base-100">
                @foreach ($activeFriend['messages'] as $i => $msg)
                    <div wire:key="msg-{{ $activeFriend['id'] }}-{{ $i }}"
                         wire:click="selectMessage({{ $i }})"
                         class="{{ $msg['from_me'] ? 'bg-indigo-600 text-white self-end ml-auto' : 'bg-gray-200' }}
                                {{ $selectedMessageIndex === $i ? 'scale-105' : '' }}
                                p-3 rounded max-w-[80%] break-words whitespace-pre-wrap transition transform cursor-pointer relative">
                        {{ $msg['text'] }}

                        @if ($msg['from_me'] && $selectedMessageIndex === $i)
                            <div class="flex gap-3 absolute right-0 -top-6 text-xs text-base-content">
                                <button wire:click.stop="startEdit({{ $i }})"><x-tabler-edit class="w-4 h-4" /></button>
                                <button wire:click.stop="confirmDelete({{ $i }})"><x-tabler-trash class="w-4 h-4" /></button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Message Input -->
            <form wire:submit.prevent="{{ $editingMessageIndex !== null ? 'saveEdit' : 'send' }}"
                  class="px-6 py-4 border-t border-base-300 bg-base-100 flex items-center gap-3">
                <x-tabler-mood-smile class="w-5 h-5 text-base-content hover:text-yellow-500" />
                <x-tabler-microphone class="w-5 h-5 text-base-content hover:text-red-500" />
                <x-tabler-paperclip class="w-5 h-5 text-base-content hover:text-blue-500" />

                <input type="text"
                       wire:model="{{ $editingMessageIndex !== null ? 'editingText' : 'newMessage' }}"
                       class="flex-1 px-4 py-2 border border-gray-500 rounded-lg focus:border-indigo-600 bg-base-100"
                       placeholder="{{ $editingMessageIndex !== null ? 'Edit your message...' : 'Type a message...' }}" />

                @if ($editingMessageIndex !== null)
                    <button type="button" wire:click="cancelEdit" class="bg-base-300 text-base-content px-3 py-2 rounded hover:bg-base-400">Cancel</button>
                    <button type="submit" class="bg-indigo-600 text-white px-3 py-2 rounded hover:bg-indigo-600">Save</button>
                @else
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-600">Send</button>
                @endif
            </form>
        @else
            <div class="flex-1 flex items-center justify-center text-base-content">
                <p>Select a friend to start chatting.</p>
            </div>
        @endif

        <!-- Delete Modal -->
        @if ($showDeleteModal)
            <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">
                <div class="bg-base-100 p-6 rounded shadow-lg">
                            <p class="text-base-content mb-4">Are you sure you want to delete this message?</p>
                    <div class="flex justify-end gap-3">
                        <button wire:click="cancelDelete" class="px-4 py-2 bg-base-300 rounded hover:bg-base-400">No</button>
                        <button wire:click="deleteMessage" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Yes</button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    window.addEventListener('scroll-to-bottom', () => {
        setTimeout(() => {
            const chatWindow = document.querySelector('[x-chat-scroll]');
            if (chatWindow) {
                chatWindow.scrollTop = chatWindow.scrollHeight;
            }
        }, 50);
    });
</script>



@endpush

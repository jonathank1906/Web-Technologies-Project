<div class="flex h-screen bg-base-200 text-base-content font-sans relative">
    <!-- Friend List -->
    <div class="w-1/3 bg-base-200 border-r border-base-300 flex flex-col">
        <!-- Search Bar -->
        <div class="p-4 border-b border-base-300 relative">
            <div class="relative">
                <x-tabler-search class="text-base-content/60 absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5" />
                <input type="text"
                    wire:model.live="search"
                    class="w-full rounded-lg border border-base-300 placeholder-base-content/60 bg-black/10 dark:bg-black/20 pl-10 pr-3 py-2
                        transition duration-150 ease-out focus:ring-2 focus:ring-primary focus:outline-none"
                    placeholder="Search friends..." />
        </div>

        <!-- Friend List -->
        <div class="flex-1 overflow-y-auto px-4 pt-2 space-y-4">
            @forelse ($this->filteredFriends as $friend)
                <div wire:key="friend-{{ $friend['id'] }}"
                     wire:click="selectFriend({{ $friend['id'] }})"
                     wire:loading.class="opacity-50"
                     class="flex items-start gap-3 p-3 bg-base-100 rounded-lg hover:bg-base-300/50 cursor-pointer transition shadow">
                    <div class="relative w-12 h-12 flex items-center justify-center text-2xl bg-base-100 rounded-full shadow">
                        <span>{{ $friend['img'] }}</span>
                        <img src="/flags/{{ $friend['flag'] }}.png"
                             class="absolute bottom-0 right-0 w-4 h-4 rounded-full border border-base-100" />
                    </div>

                    <div class="flex flex-col text-sm">
                        <span class="font-semibold text-gray-900 text-base">{{ $friend['name'] }}</span>
                        <span class="text-xs text-gray-600 italic">{{ $friend['lang'] }}</span>
                        <span class="text-xs text-gray-500 mt-1 truncate">
                            {{ \Illuminate\Support\Str::limit(last($friend['messages'])['text'] ?? '', 13, '...') }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 mt-6">No results found</div>
            @endforelse
        </div>
    </div>

    <!-- Chat Column -->
    <div class="w-2/3 flex flex-col relative">
        <!-- Spinner -->
        <div wire:loading.flex class="absolute inset-0 bg-white bg-opacity-50 justify-center items-center z-50">
            <x-tabler-loader-2 class="animate-spin w-6 h-6 text-gray-500" />
        </div>

        @if ($activeFriend)
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-base-300 bg-base-100 shadow">
                <div class="flex items-center gap-3">
                    <div class="relative w-10 h-10 flex items-center justify-center text-xl bg-base-100 rounded-full shadow">
                        <span>{{ $activeFriend['img'] }}</span>
                        <img src="/flags/{{ $activeFriend['flag'] }}.png"
                             class="absolute bottom-0 right-0 w-4 h-4 rounded-full border border-base-100" />
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-gray-800">{{ $activeFriend['name'] }}</h2>
                        <p class="text-xs text-gray-500">{{ $activeFriend['lang'] }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 text-gray-600">
                    <x-tabler-phone class="w-5 h-5 hover:text-green-600 transition" />
                    <x-tabler-dots-vertical class="w-5 h-5 hover:text-gray-800 transition" />
                </div>
            </div>

            <!-- Messages -->
            <div x-chat-scroll class="flex-1 overflow-y-auto px-6 py-4 space-y-3 bg-base-200">
                @foreach ($activeFriend['messages'] as $i => $msg)
                    <div wire:key="msg-{{ $activeFriend['id'] }}-{{ $i }}"
                         wire:click="selectMessage({{ $i }})"
                         class="{{ $msg['from_me'] ? 'bg-primary text-primary-content self-end ml-auto' : 'bg-base-100' }}
                                {{ $selectedMessageIndex === $i ? 'scale-105 ring-2 ring-secondary' : '' }}
                                p-3 rounded-lg max-w-sm transition transform cursor-pointer relative">
                        {{ $msg['text'] }}

                        @if ($msg['from_me'] && $selectedMessageIndex === $i)
                            <div class="flex gap-3 absolute right-0 -top-6 text-xs text-gray-600">
                                <button wire:click.stop="startEdit({{ $i }})"><x-tabler-edit class="w-4 h-4" /></button>
                                <button wire:click.stop="confirmDelete({{ $i }})"><x-tabler-trash class="w-4 h-4" /></button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Message Input -->
            <div class="px-6 py-4 border-t border-base-300 bg-base-100 flex items-center gap-3">
                <x-tabler-mood-smile class="w-5 h-5 text-base-content/60 hover:text-warning transition" />
                <x-tabler-microphone class="w-5 h-5 text-base-content/60 hover:text-error transition" />
                <x-tabler-paperclip class="w-5 h-5 text-base-content/60 hover:text-info transition" />

                <input type="text"
                       wire:model.live="{{ $editingMessageIndex !== null ? 'editingText' : 'newMessage' }}"
                       wire:keydown.enter.prevent="$wire.{{ $editingMessageIndex !== null ? 'saveEdit()' : 'send()' }}"
                       class="flex-1 px-4 py-2 border border-base-300 rounded-lg bg-base-200 placeholder-base-content/60 focus:ring-2 focus:ring-primary focus:outline-none"
                       placeholder="{{ $editingMessageIndex !== null ? 'Edit your message...' : 'Type a message...' }}" />

                @if ($editingMessageIndex !== null)
                    <button type="button" wire:click="cancelEdit" class="bg-base-300 text-base-content px-3 py-2 rounded-lg hover:bg-base-300/80 transition">Cancel</button>
                    <button type="button" wire:click="saveEdit" class="bg-primary text-primary-content px-3 py-2 rounded-lg hover:bg-primary/80 transition">Save</button>
                @else
                    <button type="button" wire:click="send" class="bg-primary text-primary-content px-4 py-2 rounded-lg hover:bg-primary/80 transition">Send</button>
                @endif
            </div>
        @else
            <div class="flex-1 flex items-center justify-center text-gray-400">
                <p>Select a friend to start chatting.</p>
            </div>
        @endif

            <!-- Delete Modal -->
        @if ($showDeleteModal)
            <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                <div class="bg-base-100 p-6 rounded-lg shadow">
                    <p class="text-base-content mb-4">Are you sure you want to delete this message?</p>
                    <div class="flex justify-end gap-3">
                        <button wire:click="cancelDelete" class="px-4 py-2 bg-base-300 text-base-content rounded-lg hover:bg-base-300/80 transition">No</button>
                        <button wire:click="deleteMessage" class="px-4 py-2 bg-error text-error-content rounded-lg hover:bg-error/80 transition">Yes</button>
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

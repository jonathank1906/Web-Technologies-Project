<div class="flex h-screen bg-[#f0f2f5] text-gray-800 font-sans relative">

    <!-- Friend List -->
    <div class="w-1/3 bg-[#ffeaea] border-r border-gray-300 flex flex-col">
        <!-- Search Bar -->
        <div class="p-4 border-b border-gray-300 relative">
            <input type="text"
                   wire:model.live="search"
                   class="w-full pl-4 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                   placeholder="Search friends..." />
        </div>

        <!-- Friend List -->
        <div class="flex-1 overflow-y-auto px-4 pt-2 space-y-4">
            @forelse ($this->filteredFriends as $friend)
                <div wire:click="selectFriend({{ $friend['id'] }})"
                     wire:loading.class="opacity-50"
                     class="flex items-start gap-3 p-3 bg-white rounded-lg hover:bg-yellow-100 cursor-pointer transition shadow-sm">
                    <div class="relative w-12 h-12 flex items-center justify-center text-2xl bg-white rounded-full shadow">
                        <span>{{ $friend['img'] }}</span>
                        <img src="/flags/{{ $friend['flag'] }}.png"
                             class="absolute bottom-0 right-0 w-4 h-4 rounded-full border border-white" />
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
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-white shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="relative w-10 h-10 flex items-center justify-center text-xl bg-white rounded-full shadow">
                        <span>{{ $activeFriend['img'] }}</span>
                        <img src="/flags/{{ $activeFriend['flag'] }}.png"
                             class="absolute bottom-0 right-0 w-4 h-4 rounded-full border border-white" />
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
            <div class="flex-1 overflow-y-auto px-6 py-4 space-y-3 bg-[#f5f6f8]">
                @foreach ($activeFriend['messages'] as $i => $msg)
                    <div wire:click="selectMessage({{ $i }})"
                         class="{{ $msg['from_me'] ? 'bg-blue-500 text-white self-end ml-auto' : 'bg-gray-200' }}
                                {{ $selectedMessageIndex === $i ? 'scale-105 ring-2 ring-yellow-400' : '' }}
                                p-3 rounded max-w-sm transition transform cursor-pointer relative">
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
            <form wire:submit.prevent="{{ $editingMessageIndex !== null ? 'saveEdit' : 'sendMessage' }}"
                  class="px-6 py-4 border-t bg-white flex items-center gap-3">
                <x-tabler-mood-smile class="w-5 h-5 text-gray-500 hover:text-yellow-500" />
                <x-tabler-microphone class="w-5 h-5 text-gray-500 hover:text-red-500" />
                <x-tabler-paperclip class="w-5 h-5 text-gray-500 hover:text-blue-500" />

                <input type="text"
                       wire:model="{{ $editingMessageIndex !== null ? 'editingText' : 'newMessage' }}"
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                       placeholder="{{ $editingMessageIndex !== null ? 'Edit your message...' : 'Type a message...' }}" />

                @if ($editingMessageIndex !== null)
                    <button type="button" wire:click="cancelEdit" class="bg-gray-300 text-gray-800 px-3 py-2 rounded hover:bg-gray-400">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600">Save</button>
                @else
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Send</button>
                @endif
            </form>
        @else
            <div class="flex-1 flex items-center justify-center text-gray-400">
                <p>Select a friend to start chatting.</p>
            </div>
        @endif

        <!-- Delete Modal -->
        @if ($showDeleteModal)
            <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">
                <div class="bg-white p-6 rounded shadow-lg">
                    <p class="text-gray-700 mb-4">Are you sure you want to delete this message?</p>
                    <div class="flex justify-end gap-3">
                        <button wire:click="cancelDelete" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">No</button>
                        <button wire:click="deleteMessage" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Yes</button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

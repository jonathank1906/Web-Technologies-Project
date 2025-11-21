<div class="flex h-screen bg-base-200 text-base-content font-sans relative items-stretch overflow-hidden">
    {{-- Sidebar --}}
    <div class="w-1/3 bg-base-100 border-r border-base-300 flex flex-col h-full">
        <div class="p-4">
            <div class="relative">
                <x-tabler-search class="text-gray-600 dark:text-gray-400 absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 pointer-events-none" />
                <input type="text"
                    wire:model.live.debounce.300ms="search"
                    class="w-full pl-10 pr-4 py-2 border-gray-400/30 dark:border-gray-500 bg-base-100 rounded-lg focus:outline-none focus:ring-indigo-600"
                    placeholder="Search friends..." />
            </div>
        </div>

        <div class="flex-1 overflow-y-auto px-4 pt-2 space-y-4">
            @forelse ($filteredFriends as $friend)
                <div wire:key="friend-{{ $friend['id'] }}"
                    wire:click="selectFriend({{ $friend['id'] }})"
                    class="flex items-start gap-3 p-3 bg-base-100 rounded-lg cursor-pointer shadow-sm transition duration-150 ease-out hover:bg-gray-500/10">
                    <div class="relative w-12 h-12 flex items-center justify-center text-2xl bg-indigo-600 rounded-full shadow">
                        <span>{{ $friend['img'] }}</span>
                        <img src="{{ $friend['flag'] }}" class="absolute bottom-0 right-0 w-4 h-4 object-cover rounded-full border border-base-100 shadow" />
                    </div>
                    <div class="flex flex-col text-sm">
                        <span class="font-semibold text-base-content text-base">{{ $friend['name'] }}</span>
                        <span class="text-xs text-base-content italic">{{ $friend['lang'] }}</span>
                        <span class="text-xs text-base-content mt-1 truncate">
                            {{ \Illuminate\Support\Str::limit(last($friend['messages'])['body'] ?? '', 13, '...') }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="text-center text-base-content mt-6">No results found</div>
            @endforelse
        </div>
    </div>

    {{-- Chat Window --}}
    <div class="w-2/3 flex flex-col relative h-full min-h-0">
        @if ($activeFriend)
            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-base-300 bg-base-100 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="relative w-10 h-10 flex items-center justify-center text-xl bg-indigo-600 rounded-full shadow">
                        <span>{{ $activeFriend['img'] }}</span>
                        <img src="{{ $activeFriend['flag'] }}" class="absolute bottom-0 right-0 w-4 h-4 rounded-full border border-base-100" />
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-base-content">{{ $activeFriend['name'] }}</h2>
                        <p class="text-xs text-base-content">{{ $activeFriend['lang'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Messages --}}
            <div wire:poll.1s="refreshMessages" x-chat-scroll class="flex-1 overflow-y-auto px-6 py-4 bg-base-100">
                <div class="flex flex-col gap-3 content-start">
                    @foreach ($activeFriend['messages'] as $msg)
                        <div wire:key="msg-{{ $msg['id'] }}"
                            wire:click="selectMessage({{ $msg['id'] }})"
                            class="{{ $msg['from_me'] ? 'bg-indigo-600 text-white self-end' : 'bg-blue-500 text-white self-start' }}
                            {{ $selectedMessageId === $msg['id'] ? 'scale-105 shadow-md' : '' }}
                            p-3 rounded max-w-[80%] break-words transition transform cursor-pointer relative group">

                            {{-- Text --}}
                            @if($msg['body'])
                                <p>{{ $msg['body'] }}</p>
                            @endif

                            {{-- Attachment --}}
                            @if($msg['attachment_path'])
                                @php $type = $msg['attachment_type']; @endphp

                                @if($type === 'image')
                                    <img src="{{ asset('storage/' . $msg['attachment_path']) }}" class="w-128 h-128 object-cover rounded mt-2" />
                                @elseif($type === 'audio')
                                    <audio controls class="w-40 mt-2"><source src="{{ asset('storage/' . $msg['attachment_path']) }}"></audio>
                                @elseif($type === 'document')
                                    <a href="{{ asset('storage/' . $msg['attachment_path']) }}" target="_blank" class="mt-2 inline-flex items-center gap-2">
                                        <x-tabler-file-text class="w-4 h-4" /> Download
                                    </a>
                                @elseif($type === 'video')
                                    <div wire:ignore class="mt-2 max-w-[400px]">
                                        <video controls 
                                            preload="metadata" 
                                            class="w-full rounded-lg bg-black"
                                            style="max-height: 400px;">
                                            <source src="{{ route('stream.attachment', ['path' => $msg['attachment_path']]) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                @else
                                    <a href="{{ asset('storage/' . $msg['attachment_path']) }}" class="mt-2 inline-block">Open file</a>
                                @endif
                            @endif

                            {{-- Action Buttons --}}
                            @if ($msg['from_me'] && $selectedMessageId === $msg['id'])
                                <div class="flex gap-3 absolute right-0 -top-6 text-xs text-base-content bg-base-100 p-1 rounded shadow-sm">
                                    <button type="button" wire:click.stop="startEdit({{ $msg['id'] }})" class="hover:text-blue-500">
                                        <x-tabler-edit class="w-4 h-4" />
                                    </button>
                                    <button type="button" wire:click.stop="confirmDelete({{ $msg['id'] }})" class="hover:text-red-500">
                                        <x-tabler-trash class="w-4 h-4" />
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Input --}}
            <form wire:submit.prevent="handleSubmit" class="px-6 py-4 border-t border-base-300 bg-base-100 flex items-center gap-3">
                <input type="file" id="attachmentInput" wire:model="attachment" class="hidden" accept="image/*,audio/*,video/*,.mp4,.mov,.pdf,.txt,.doc,.docx" />
                <x-tabler-mood-smile class="w-5 h-5 text-base-content hover:text-yellow-500" />
                <x-tabler-microphone class="w-5 h-5 text-base-content hover:text-red-500" />
                <label for="attachmentInput" class="cursor-pointer">
                    <x-tabler-paperclip class="w-5 h-5 text-base-content hover:text-blue-500" />
                </label>

                {{-- Preview --}}
                @if($attachment)
                    <div class="flex items-center gap-3 p-2 bg-base-200 rounded-lg">
                        @php $mime = $attachment->getMimeType(); @endphp

                        @if(str_contains($mime, 'image'))
                            <img src="{{ $attachment->temporaryUrl() }}" class="w-16 h-16 object-cover rounded shadow" />
                        @elseif(str_contains($mime, 'audio'))
                            <audio controls class="w-36"><source src="{{ $attachment->temporaryUrl() }}"></audio>
                        @elseif(str_contains($mime, 'video'))
                        <x-tabler-video class="w-6 h-6 text-purple-600" />
                        <span>{{ $attachment->getClientOriginalName() }}</span>
                        @elseif(str_contains($mime, 'pdf'))
                            <x-tabler-file-text class="w-6 h-6 text-red-600" /><span>{{ $attachment->getClientOriginalName() }}</span>
                        @elseif(str_contains($mime, 'text') || str_contains($mime, 'msword') || str_contains($mime, 'officedocument'))
                            <x-tabler-file-description class="w-6 h-6 text-blue-600" /><span>{{ $attachment->getClientOriginalName() }}</span>
                        @else
                            <x-tabler-file class="w-6 h-6 text-gray-600" /><span>{{ $attachment->getClientOriginalName() }}</span>
                        @endif

                        <button type="button" wire:click="$set('attachment', null)" class="text-red-500 hover:text-red-700 text-sm">Remove</button>
                    </div>
                @endif

                <input type="text" wire:model="newMessage" class="flex-1 px-4 py-2 border border-gray-500 rounded-lg focus:border-indigo-600 bg-base-100" placeholder="Type a message..." x-data x-ref="messageInput" @message-sent.window="$refs.messageInput.value = ''" />
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Send</button>
            </form>
        @else
            <div class="flex-1 flex items-center justify-center text-base-content">
                <p>Select a friend to start chatting.</p>
            </div>
        @endif

        {{-- Delete Modal --}}
        @if ($showDeleteModal)
            <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">
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
// Handle scroll to bottom
window.addEventListener('scroll-to-bottom', () => {
    setTimeout(() => {
        const chatWindow = document.querySelector('[x-chat-scroll]');
        if (chatWindow) chatWindow.scrollTop = chatWindow.scrollHeight;
    }, 50);
});
</script>
@endpush
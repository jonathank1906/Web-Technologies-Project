<div class="max-w-lg mx-auto">
    {{-- header --}}
    <header class="flex items-center gap-3 mb-2">
        @if ($post->user->getProfilePictureUrl())
        <img src="{{ $post->user->getProfilePictureUrl() }}" alt="{{ $post->user->name }}'s profile"
            class="w-12 h-12 rounded-full shadow object-cover aspect-square">
        @else
        <span class="text-xl font-bold text-primary-content flex items-center justify-center w-12 h-12 rounded-full">
            {{ strtoupper(substr($post->user->name, 0, 1)) }}
        </span>
        @endif

        <div class="flex justify-between items-center w-full relative">
            <h5 class="font-semibold text-sm">{{ $post->user->name }}</h5>
            <div class="relative">
                <button onclick="toggleMenu({{ $post->id }})" id="dots-btn-{{ $post->id }}">
                    <x-tabler-dots />
                </button>
                @if(auth()->id() === $post->user_id)
                <div id="menu-{{ $post->id }}" class="absolute right-0 mt-2 w-32 bg-white border rounded shadow-lg hidden z-10">
                    <form wire:submit.prevent="destroy" onsubmit="return confirm('Are you sure you want to delete this post?');">
                        <button type="submit" class="w-full text-left px-4 py-2 hover:bg-red-100 text-red-600">
                            Delete
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </header>
    <script>
        function toggleMenu(postId) {
            const menu = document.getElementById('menu-' + postId);
            menu.classList.toggle('hidden');
            document.addEventListener('click', function handler(e) {
                if (!e.target.closest('#dots-btn-' + postId) && !e.target.closest('#menu-' + postId)) {
                    menu.classList.add('hidden');
                    document.removeEventListener('click', handler);
                }
            });
        }
    </script>

    {{-- Description --}}
    @if($post->description)
    <p class="mb-4 text-gray-700 dark:text-gray-300">{{ $post->description }}</p>
    @endif

    {{-- Media Slider (only if more than 1 media) --}}
    @if($post->media->count() > 1)
    <div id="post-slider-{{ $post->id }}" class="keen-slider mb-4">
        @foreach($post->media as $media)
        <div class="keen-slider__slide">
            @if($media->mime === 'image')
            <img src="{{ $media->url }}" alt="Post media" class="w-full h-full object-cover">
            @elseif($media->mime === 'video')
            <video controls class="w-full h-full">
                <source src="{{ $media->url }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            @endif
        </div>
        @endforeach
    </div>
    @elseif($post->media->count() === 1)
    {{-- Single media without slider --}}
    <div class="mb-4">
        @php $media = $post->media->first(); @endphp
        @if($media->mime === 'image')
        <img src="{{ $media->url }}" alt="Post media" class="w-full h-auto object-cover rounded-lg">
        @elseif($media->mime === 'video')
        <video controls class="w-full h-auto rounded-lg">
            <source src="{{ $media->url }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        @endif
    </div>
    @endif

    {{-- Footer --}}
    <footer>
        <div class="flex gap-4 items-center my-2">
            <button
                class="like-btn"
                data-post-id="{{ $post->id }}"
                data-liked="{{ auth()->check() && $post->isLikedBy(auth()->user()) ? 'true' : 'false' }}">
                @if(auth()->check() && $post->isLikedBy(auth()->user()))
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-thumb-up">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M13 3a3 3 0 0 1 2.995 2.824l.005 .176v4h2a3 3 0 0 1 2.98 2.65l.015 .174l.005 .176l-.02 .196l-1.006 5.032c-.381 1.626 -1.502 2.796 -2.81 2.78l-.164 -.008h-8a1 1 0 0 1 -.993 -.883l-.007 -.117l.001 -9.536a1 1 0 0 1 .5 -.865a2.998 2.998 0 0 0 1.492 -2.397l.007 -.202v-1a3 3 0 0 1 3 -3z" />
                    <path d="M5 10a1 1 0 0 1 .993 .883l.007 .117v9a1 1 0 0 1 -.883 .993l-.117 .007h-1a2 2 0 0 1 -1.995 -1.85l-.005 -.15v-7a2 2 0 0 1 1.85 -1.995l.15 -.005h1z" />
                </svg>
                @else
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-thumb-up">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M7 11v8a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-7a1 1 0 0 1 1 -1h3a4 4 0 0 0 4 -4v-1a2 2 0 0 1 4 0v5h3a2 2 0 0 1 2 2l-1 5a2 3 0 0 1 -2 2h-7a3 3 0 0 1 -3 -3" />
                </svg>
                @endif
            </button>
            <span id="like-count-{{ $post->id }}">{{ $post->likes_count ?? 0 }}</span>
            <button onclick="window.location='{{ route('post.show', $post) }}'">
                <x-tabler-message-circle-2 />
            </button>
            <span id="comment-count-{{ $post->id }}">{{ $post->comments_count ?? 0 }}</span>
        </div>
    </footer>
</div>
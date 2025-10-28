<div class="max-w-lg mx-auto">
    {{-- header --}}
    <header class="flex items-center gap-3 mb-2">
        <x-avatar class="h-12 w-12" />

        <div class="flex justify-between items-center w-full">
            <h5 class="font-semibold text-sm">{{ $post->user->name }}</h5>
            <button>
                <x-tabler-dots />
            </button>
        </div>
    </header>

    {{-- Description --}}
    @if($post->description)
        <p class="mb-4 text-gray-700 dark:text-gray-300">{{ $post->description }}</p>
    @endif

    {{-- Media Slider --}}
    @if($post->media->count() > 0)
        <div class="keen-slider mb-4">
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
    @endif

    {{-- footer --}}
    <footer>
        <div class="flex gap-4 items-center my-2">
            <span>
                <x-tabler-thumb-up />
            </span>
            <span>
                <x-tabler-message-circle-2 />
            </span>
            <span class="ml-auto">
                <x-tabler-share-3 />
            </span>
        </div>
    </footer>
</div>
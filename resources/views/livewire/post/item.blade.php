<div class="max-w-lg mx-auto">
    {{-- header --}}
    <header class="flex items-center gap-3 mb-2">
        <x-avatar class="h-12 w-12" />

        <div class="flex justify-between items-center w-full">
            <h5 class="font-semibold text-sm">{{ fake()->name }}</h5>
            <button>
                <x-tabler-dots />
            </button>
        </div>
    </header>

    {{-- main --}}
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.

    {{-- slider --}}
    <div id="my-keen-slider" class="keen-slider">
        <div class="keen-slider__slide number-slide1">1</div>
        <div class="keen-slider__slide number-slide2">2</div>
        <div class="keen-slider__slide number-slide3">3</div>
        <div class="keen-slider__slide number-slide4">4</div>
        <div class="keen-slider__slide number-slide5">5</div>
        <div class="keen-slider__slide number-slide6">6</div>
    </div>

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
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
    <main class="my-4">
        <img
            src="https://media.istockphoto.com/id/517188688/photo/mountain-landscape.jpg?s=612x612&w=0&k=20&c=A63koPKaCyIwQWOTFBRWXj_PwCrR4cEoOw2S9Q7yVl8="
            alt="Post image"
            class="w-full rounded-lg object-cover" />
    </main>

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
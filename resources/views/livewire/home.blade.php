<div class="w-full">
    {{-- Header --}}
    <header class="mb-6">
        <div class="flex justify-between items-center">
            <a href="{{ route('post.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow transition">
                <x-tabler-plus class="w-5 h-5 mr-2" />
                Create Post
            </a>
        </div>
    </header>

    {{-- main --}}
    <main class="grid lg:grid-cols-12 gap-8 md:mt-10">
        <aside class="lg:col-span-8 border overflow-y-auto h-[1000px]">
            {{-- Posts --}}
            <section class="mt-5 space-y-4 p-2">
                @if ($posts)
                @foreach ($posts as $post)
                <livewire:post.item wire:key="post-{{$post->id}}" :post="$post" />
                @endforeach
                @else
                <p class="font-bol flex justify-center">No posts</p>
                @endif
            </section>
        </aside>

        <aside class="lg:col-span-4 border hidden lg:block p-4">

        </aside>
    </main>
</div>
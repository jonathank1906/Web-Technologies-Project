<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post View</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="w-full h-screen flex flex-col">
        {{-- Scrollable content --}}
        <main class="flex-1 overflow-y-auto px-4 py-6">
            <div class="max-w-2xl mx-auto">
                @include('livewire.post.item', ['post' => $post])
                <section class="mt-8">
                    <h2 class="text-lg font-bold mb-4">Comments</h2>
                    <main>
                        <section class="flex flex-col gap-2">
                            {{-- main comment --}}
                            <div class="flex items-center gap-3 py-2">
                                <x-avatar class="h-12 w-12 mb-auto" />
                                <div class="grid grid-cols-7 w-full gap-2">
                                    {{-- Comment --}}
                                    <div class="col-span-6 flex flex-wrap text-sm">
                                        <p>
                                            <span class="font-bold text-sm"> {{$post->user->name}} </span>
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quod.
                                        </p>
                                    </div>
                                    {{-- Like --}}
                                    <div class="col-span-1 flex text-right justify-end mb-auto">
                                        <button class="font=bold text=sm ml-auto">
                                            {{-- svg --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 hover:text-red-500 transition-colors duration-200" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                                            </svg>
                                        </button>
                                    </div>

                                    {{-- Footer --}}
                                    <div class="col-span-7 flex gap-2 text-sm items-center text-gray-700">
                                        <span>2d</span>
                                        <span class="font-bold">345 Likes</span>
                                        <span class="font-semibold">Reply</span>
                                    </div>

                                </div>
                            </div>

                            {{-- reply comment --}}
                            <div class="flex items-center gap-3 w-11/12 ml-auto py-2">
                                <x-avatar class="h-12 w-12 mb-auto" />
                                <div class="grid grid-cols-7 w-full gap-2">
                                    {{-- Comment --}}
                                    <div class="col-span-6 flex flex-wrap text-sm">
                                        <p>
                                            <span class="font-bold text-sm"> {{$post->user->name}} </span>
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quod.
                                        </p>
                                    </div>
                                    {{-- Like --}}
                                    <div class="col-span-1 flex text-right justify-end mb-auto">
                                        <button class="font=bold text=sm ml-auto">
                                            {{-- svg --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 hover:text-red-500 transition-colors duration-200" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                                            </svg>
                                        </button>
                                    </div>

                                    {{-- Footer --}}
                                    <div class="col-span-7 flex gap-2 text-sm items-center text-gray-700">
                                        <span>2d</span>
                                        <span class="font-bold">345 Likes</span>
                                        <span class="font-semibold">Reply</span>
                                    </div>

                                </div>
                            </div>
                        </section>
                    </main>

                    @foreach($post->comments as $comment)
                    <div class="mb-4 p-4 bg-base-200 rounded">
                        <div class="font-semibold">{{ $comment->user->name }}</div>
                        <div>{{ $comment->content }}</div>
                    </div>
                    @endforeach
                </section>

            </div>
        </main>
    </div>

</body>

</html>
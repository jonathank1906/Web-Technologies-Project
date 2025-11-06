<div class="w-full h-screen flex flex-col">
    {{-- Scrollable content --}}
    <main class="flex-1 overflow-y-auto px-4 py-6">
        <div class="max-w-2xl mx-auto">
            @include('livewire.post.item', ['post' => $post])
            <section class="mt-8">
                <h2 class="text-lg font-bold mb-4">Comments</h2>
                {{-- Leave a comment --}}
                <form wire:submit.prevent="addComment" class="grid grid-cols-12 items-center w-full">
                    @csrf

                    <input wire:model.defer="body" type="text" placeholder=" Leave a comment "
                        class="border-0 col-span-10 bg-base-200 text-base-content placeholder:text-base-content placeholder:text-sm outline-none focus:outline-none px-0 rounded-lg hover:ring-0 focus:ring-0">
                    <div class="col-span-1 ml-auto flex justify-end text-right">
                        <button type="submit"
                            class="text-sm font-semibold flex justify-end text-blue-500">
                            Post
                        </button>
                    </div>

                    <span class="col-span-1 ml-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
                        </svg>
                    </span>
                </form>
                <main>
                    @if($comments)

                    @foreach ($comments as $comment)

                    <section class="flex flex-col gap-2">
                        {{-- main comment --}}
                        @include('livewire.post.partials.comment')

                        @if($comment->replies)

                        @foreach ($comment->replies as $reply)

                        {{-- reply comment --}}
                        @include('livewire.post.partials.reply')
                        @endforeach
                        @endif

                    </section>

                    @endforeach

                    @else
                    No comments

                    @endif
                </main>
            </section>
        </div>
    </main>
</div>
<div class="w-full h-screen flex flex-col">
    {{-- Scrollable content --}}
    <main class="flex-1 overflow-y-auto px-4 py-6">
        <div class="max-w-2xl mx-auto">
            @include('livewire.post.item', ['post' => $post])
            <section class="mt-8">
                {{-- Leave a comment --}}
                <form wire:submit.prevent="addComment" class="grid grid-cols-12 items-center w-full">
                    @csrf

                    <div class="col-span-10">
                        <x-input-label for="body" :value="__('Leave a comment')" />
                        <x-text-input
                            id="body"
                            wire:model.defer="body"
                            class="block mt-1 w-full"
                            type="text"
                            name="body"
                            :value="old('body')"
                            autocomplete="off" />
                        <x-input-error :messages="$errors->get('body')" class="mt-2" />
                    </div>
                    <div class="col-span-2 flex justify-end items-end mt-6">
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Post
                        </button>
                    </div>
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
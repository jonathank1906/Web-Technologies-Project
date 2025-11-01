<div class="max-w-2xl mx-auto py-8">
    @include('livewire.post.item', ['post' => $post])
    <section class="mt-8">
        <h2 class="text-lg font-bold mb-4">Comments</h2>
        @foreach($post->comments as $comment)
        <div class="mb-4 p-4 bg-base-200 rounded">
            <div class="font-semibold">{{ $comment->user->name }}</div>
            <div>{{ $comment->content }}</div>
        </div>
        @endforeach
    </section>
</div>
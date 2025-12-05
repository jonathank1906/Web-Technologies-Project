<section id="blocked-users">
    <header>
        <h2 class="text-lg font-medium text-base-content">
            {{ __('Blocked Users') }}
        </h2>
        <p class="mt-1 text-sm text-base-content">
            {{ __("These users are currently blocked from interacting with you.") }}
        </p>
    </header>

    <div class="mt-6" x-data="{ showList: true }">
        <x-secondary-button @click="showList = !showList">
            <span x-text="showList ? 'Hide List' : 'Show List'"></span>
        </x-secondary-button>

        <div x-show="showList" x-transition class="mt-4 space-y-4">
            @forelse ($blockedUsers as $blockedUser)
                <div class="bg-base-100 p-4 rounded-lg shadow flex justify-between items-center">
                    <div>
                        <p class="text-base-content font-medium">{{ $blockedUser->name }}</p>
                        <p class="text-sm text-base-content/60">Blocked since {{ $blockedUser->blockedUsers()->where('blocked_id', $blockedUser->id)->first()?->created_at->format('M d, Y') ?? 'Unknown' }}</p>
                    </div>
                    <button @click="unblockUser('{{ $blockedUser->public_id }}')" class="btn btn-outline btn-sm">
                        Unblock
                    </button>
                </div>
            @empty
                <p class="text-sm text-base-content/60 italic">You haven't blocked any users yet.</p>
            @endforelse
        </div>
    </div>
</section>

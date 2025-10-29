
<div class="connect-page p-6">
    <div class="container flex gap-6">

        <!-- Left Column -->
        <div class="left-column w-2/3 bg-white p-4 rounded shadow">
            <h1 class="text-lg font-bold mb-4">Find Partner</h1>

            <div class="search-filter-wrapper mb-4">
                <input type="text" class="search-input w-full p-2 border rounded" placeholder="Search users..." wire:model.debounce.300ms="query">
            </div>

            <div class="user-list space-y-2">
                @foreach($this->users as $user)
                    <div class="flex items-center justify-between p-2 border rounded">
                        <div>
                            <div class="font-semibold">{{ $user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $user->email }}</div>
                        </div>
                        <div>
                            <button wire:click.prevent="sendRequest({{ $user->id }})" class="px-3 py-1 bg-blue-500 text-white rounded dark:bg-blue-700 dark:hover:bg-blue-800">Connect</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Right Column -->
        <div class="right-column w-1/3 bg-white p-4 rounded shadow">
            <h2 class="text-lg font-bold mb-4">Pending Requests</h2>
            <div class="pending-list space-y-2">
                @foreach($this->pending as $req)
                    <div class="pending-item flex items-center justify-between border p-2 rounded">
                        <div>
                            <div class="font-semibold">{{ $req->sender->name }}</div>
                            <div class="text-xs text-gray-500">{{ $req->sender->email }}</div>
                        </div>
                        <div class="flex gap-2">
                            <button wire:click.prevent="acceptRequest({{ $req->id }})" class="px-2 py-1 bg-green-500 text-white rounded dark:bg-green-700 dark:hover:bg-green-800 border border-white dark:border-gray-300 shadow">Accept</button>
                            <button wire:click.prevent="declineRequest({{ $req->id }})" class="px-2 py-1 bg-red-500 text-white rounded dark:bg-red-700 dark:hover:bg-red-800 border border-white dark:border-gray-300 shadow">Decline</button>
                        </div>
                    </div>
                @endforeach
                @if($this->pending->isEmpty())
                    <div class="text-sm text-gray-500">No pending requests</div>
                @endif
            </div>
        </div>
    </div>
</div>
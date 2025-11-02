<div class="flex justify-center gap-4">
    <!-- Main Column -->
    <div class="flex flex-col max-w-2xl min-h-screen border-x border-base-300 bg-base-200 shadow flex-auto">
        
        <!-- Connections Section -->
        <section id="connectionsView">
            <header class="px-4 py-2 flex justify-between items-center">
                <h1 id="connectionsTitle" class="font-bold text-2xl">Connections</h1>
                <div>
                    <button id="toggleViewBtn"
                        class="lg:hidden hover:bg-gray-700/50 active:bg-gray-600/50 active:scale-90 text-gray-200 rounded-full p-2 transition relative">
                        <x-tabler-bell-filled class="text-base-content w-6 h-6" />
                        <span
                            class="{{ $requests->isNotEmpty() ? 'block' : 'hidden' }} absolute top-2 right-2 w-2.5 h-2.5 rounded-full bg-red-600 border border-base-100">
                        </span>
                    </button>
                </div>
            </header>

            <!-- Search Bar -->
            <div class="flex px-4 py-2">
                <div class="relative grow">
                    <x-tabler-search
                        class="text-gray-600 dark:text-gray-400 absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5" />
                    <input wire:model.live.debounce.100ms="search" type="search" 
                           placeholder="Search users…" id="searchInput" 
                           class="w-full rounded-lg border border-gray-400/30 dark:border-gray-500 placeholder-gray-600 dark:placeholder-gray-400 bg-black/10 dark:bg-black/20 pl-10 pr-3
                           transition duration-150 ease-out
                           focus:ring-indigo-600 focus:outline-none focus:ring-2">
                </div>
            </div>

            <!-- Users List -->
            <ul class="mt-5" id="userList">
                @forelse ($users as $user)
                    <li>
                        <livewire:connections.user-item :user="$user"
                            wire:key="user-{{ $user->id }}-search-{{ $search }}" />
                    </li>
                @empty
                    <li class="border-t border-base-300 w-full py-6 flex flex-col items-center justify-center text-center">
                        <x-tabler-mood-puzzled class="text-base-content w-10 h-10 text-gray-500 mb-3" />
                        <p class="text-gray-600 dark:text-gray-400 font-light">
                            No users match your search.
                        </p>
                    </li>
                @endforelse
            </ul>
        </section>

        <!-- Requests Section (hidden on large screens) -->
        <section id="requestsView" class="hidden">
            <header class="px-4 pt-2 pb-5 flex items-center gap-2">
                <button id="backToConnectionsBtn"
                        class="hover:bg-gray-700/50 active:bg-gray-600/50 active:scale-90 text-gray-200 rounded-full p-2 transition">
                    <x-tabler-arrow-left class="text-base-content w-6 h-6" />
                </button>
                <h2 id="requestsTitle" class="font-bold text-2xl">Incoming Requests</h2>
            </header>

            <!-- Requests List -->
            <ul id="requestList">
                @forelse ($requests as $request)
                    <li>
                        <livewire:connections.request-item :user="$request" wire:key="user-{{ $request->id }}" />
                    </li>
                @empty
                    <li class="border-t border-base-300 w-full py-6 flex flex-col items-center justify-center text-center">
                        <x-tabler-mail class="text-base-content w-10 h-10 text-gray-500 mb-3" />
                        <p class="text-gray-600 dark:text-gray-400 font-light">
                            No new requests at the moment.
                        </p>
                    </li>
                @endforelse
            </ul>
        </section>
    </div>

    <!-- Requests Side Column (visible on large screens) -->
    <aside class="hidden lg:flex flex-col w-[35%] max-w-xs self-start mt-5 sticky top-5 border border-base-300 bg-base-200 shadow rounded-lg">
        <header class="px-4 pt-2 pb-5">
            <h2 id="desktopRequestsTitle" class="font-bold text-2xl">Incoming Requests</h2>
        </header>
        <ul id="requestListDesktop">
            @forelse ($requests as $request)
                <li>
                    <livewire:connections.request-item :user="$request" wire:key="user-{{ $request->id }}" />
                </li>
            @empty
                <li class="border-t border-base-300 w-full py-6 flex flex-col items-center justify-center text-center">
                    <x-tabler-mail class="text-base-content w-10 h-10 text-gray-500 mb-3" />
                    <p class="text-gray-600 dark:text-gray-400 font-light">
                        No new requests at the moment.
                    </p>
                </li>
            @endforelse
        </ul>
    </aside>
</div>


<script>
    document.addEventListener("DOMContentLoaded", () => {
        const toggleViewBtn = document.getElementById("toggleViewBtn");
        const backBtn = document.getElementById("backToConnectionsBtn");
        const connectionsView = document.getElementById("connectionsView");
        const requestsView = document.getElementById("requestsView");

        let currentView = "connections";

        function showConnections() {
            if (currentView === "connections") return;
            requestsView.classList.add("hidden");
            connectionsView.classList.remove("hidden");
            currentView = "connections";
        }

        function showRequests() {
            if (currentView === "requests") return;
            connectionsView.classList.add("hidden");
            requestsView.classList.remove("hidden");
            currentView = "requests";
        }

        toggleViewBtn?.addEventListener("click", showRequests);
        backBtn?.addEventListener("click", showConnections);

        window.addEventListener("resize", () => {
            const isDesktop = window.innerWidth >= 1024;
            if (isDesktop && currentView === "requests") {
                showConnections();
            }
        });
    });
</script>
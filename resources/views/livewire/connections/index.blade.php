@vite(['resources/js/connections.js'])

<div class="flex justify-center gap-4">
    <!-- Main Column -->
    <div class="flex flex-col max-w-2xl min-h-screen border-x border-base-300 bg-base-200 shadow flex-auto">
        <!-- Connections View -->
        <main id="connectionsView" class="">
            <header class="px-4 py-2 text-left flex justify-between items-center">
                <h1 class="font-bold text-2xl">Connections</h1>
                <div>
                    <button id="toggleViewBtn"
                        class="lg:hidden hover:bg-gray-700/50 active:bg-gray-600/50 active:scale-90 text-gray-200 rounded-full p-2 transition relative">
                        <x-tabler-bell-filled class="text-base-content w-6 h-6" />
                        <div class="{{ $requests == true ? "block" : "hidden" }} absolute top-2 right-2 w-2.5 h-2.5 rounded-full bg-red-600 border border-base-100"></div>
                    </button>
                </div>

            </header>

            <section class="flex px-4 py-2">
                <form class="relative grow">
                    <x-tabler-search class="text-gray-600 dark:text-gray-400 absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5" />
                    <input type="text" placeholder="Search users.." id="searchInput" class="w-full rounded-lg border border-gray-400/30 dark:border-gray-500 placeholder-gray-600 dark:placeholder-gray-400 bg-black/10 dark:bg-black/20 pl-10 pr-3
                        transition duration-150 ease-out
                        focus:ring-indigo-600 focus:outline-none focus:ring-2">
                </form>
            </section>

            <ul class="mt-5" id="userList">
                @for ($i = 0; $i <= 3; $i++)
                    <li> <livewire:connections.user-item /> </li>
                @endfor
            </ul>
        </main>

        <!-- Requests View (smaller screens only) -->
        <main id="requestsView" class="hidden">
            <header class="px-4 pt-2 pb-5 text-left flex justify-start gap-2 items-center">
                <button id="backToConnectionsBtn"
                    class="hover:bg-gray-700/50 active:bg-gray-600/50 active:scale-90 text-gray-200 rounded-full p-2 transition">
                    <x-tabler-arrow-left class="text-base-content w-6 h-6" />
                </button>
                <h1 class="font-bold text-2xl">Requests</h1>
            </header>

            <div
                class="{{ $requests == false ? "block" : "hidden" }} border-t border-base-300 w-full py-6 flex flex-col items-center justify-center text-center">
                <x-tabler-mail class="text-base-content w-10 h-10 text-gray-500 mb-3" />
                <p class="text-gray-600 dark:text-gray-400 font-light">
                    No new requests at the moment.
                </p>
            </div>

            <ul class="{{ $requests == true ? "block" : "hidden" }}" id="requestList">
                @for ($i = 0; $i <= 3; $i++)
                    <li> <livewire:connections.request-item /></li>
                @endfor
            </ul>
        </main>
    </div>

    <!-- Side Requests Column (bigger screens only) -->
    <div
        class="hidden lg:flex flex-col w-[35%] max-w-xs self-start mt-5 sticky top-5 border border-base-300 bg-base-200 shadow rounded-lg">
        <header class="px-4 pt-2 pb-5 text-left flex justify-between items-center">
            <h1 class="font-bold text-2xl">Requests</h1>
        </header>
        <main>
            <div
                class="{{ $requests == false ? "block" : "hidden" }} border-t border-base-300 w-full py-6 flex flex-col items-center justify-center text-center">
                <x-tabler-mail class="text-base-content w-10 h-10 text-gray-500 mb-3" />
                <p class="text-gray-600 dark:text-gray-400 font-light">
                    No new requests at the moment.
                </p>
            </div>
            <ul class="{{ $requests == true ? "block" : "hidden" }}" id="requestList">
                @for ($i = 0; $i <= 3; $i++)
                    <li> <livewire:connections.request-item /></li>
                @endfor
            </ul>
        </main>
    </div>
</div>
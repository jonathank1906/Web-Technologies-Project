@vite(['resources/js/connections.js'])

<div class="flex flex-col items-center">
    <div class="container flex flex-col max-w-screen-sm border border-gray-700 rounded-lg">
        <header class="py-4 text-center">
            <h1 class="font-bold text-3xl">Find Partners</h1>
        </header>
        <main>
            <section class="flex px-4 py-2">
                <form class="relative grow">
                    <x-tabler-search class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                    <input type="text" placeholder="Search" id="searchInput" class="w-full rounded-lg border border-gray-500 placeholder-gray-400 bg-black/20 pl-10 pr-3
                        transition duration-150 ease-out
                        focus:ring-indigo-600 focus:outline-none focus:ring-2">
                </form>
                <button class="pl-4 text-white/70 transition hover:text-white active:scale-90" id="filtersBtn">
                    <x-tabler-filter class="w-5 h-5" />
                </button>
            </section>

            <ul class="flex flex-wrap justify-center gap-3 px-2 pt-3" id="filtersList">
                @foreach (['All', 'English', "Mandarin", "German", "Japanese", "Spanish", "French", "Single", "Serious Learner", "Top Learner", "New"] as $filter)
                    <li>
                        <button aria-pressed="{{ $filter === 'All' ? 'true' : 'false' }}"
                            class="select-none font-bold text-md text-white/50 bg-gray-700 rounded-full border border-gray-600 py-1.5 px-2.5
                        transition duration-150 ease-out
                        hover:text-white/90 hover:border-gray-500 active:scale-90 active:bg-indigo-500
                        aria-[pressed=true]:bg-indigo-600 aria-[pressed=true]:text-white aria-[pressed=true]:border-gray-500" id="{{ $filter }}">
                            {{ $filter }}
                        </button>
                    </li>
                @endforeach
            </ul>
 
            <ul class="mt-5" id="userList">
                @for ($i = 0; $i <= 35; $i++)
                    <li> <livewire:connections.user-item /> </li>
                @endfor
            </ul>
        </main>
        <footer>
            <p class="text-center my-2 mt-10">You've reached the end :O </p>
        </footer>
    </div>
</div>

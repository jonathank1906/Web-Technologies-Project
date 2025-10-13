@vite(['resources/js/connections.js'])

<div class="flex flex-col items-center">
    <div class="container flex flex-col max-w-screen-sm border border-gray-600 rounded-md">
        <header class="font-bold text-3xl py-4 text-center">
            <h1>Find Partners</h1>
        </header>
        <main>
            <section class="flex px-4 py-2">
                <input type="text" placeholder="Search" id="searchInput" class="grow rounded-md border-1 border-gray-500 placeholder-gray-400 bg-black/20 transition duration-200
                     focus:ring-indigo-600 focus:outline-none focus:ring-2">
                <button class="pl-4 text-white/70 transition hover:text-white active:scale-90" id="filtersBtn">
                    <x-tabler-filter class="w-5 h-5" />
                </button>
            </section>

            <ul class="flex flex-wrap justify-center gap-4 px-2 pt-3" id="filtersList">
                <li aria-pressed="true"
                    class="cursor-pointer select-none font-bold text-white/50 bg-gray-700 rounded-full py-1 px-2 transition duration-200 hover:text-white/90 active:scale-90
                     aria-[pressed=true]:bg-indigo-600 aria-[pressed=true]:text-white aria-[pressed=true]:text-opacity-100"> All </li>

                @foreach (['English', "Mandarin", "German", "Japanese", "Spanish", "French", "Single", "Serious Learner", "Top Learner", "New"] as $filter)
                    <li aria-pressed="false"
                        class="cursor-pointer select-none font-bold text-white/50 bg-gray-700 rounded-full py-1 px-2 transition duration-200 hover:text-white/90 active:scale-90
                         aria-[pressed=true]:bg-indigo-600 aria-[pressed=true]:text-white aria-[pressed=true]:text-opacity-100">{{ $filter }}</li>
                @endforeach
            </ul>


            <ul class="mt-5" id="userList">
                <li> <x-user-item /> </li>
                <li> <x-user-item /> </li>
                <li> <x-user-item /> </li>
                <li> <x-user-item /> </li>
                <li> <x-user-item /> </li>
                <li> <x-user-item /> </li>
                <li> <x-user-item /> </li>
                <li> <x-user-item /> </li>
                <li> <x-user-item /> </li>
                <li> <x-user-item /> </li>
                <li> <x-user-item /> </li>
                <li> <x-user-item /> </li>
            </ul>
        </main>
        <footer>

        </footer>
    </div>
</div>
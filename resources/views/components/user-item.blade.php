<section class="flex flex-col items-start">
    <div class="border-t border-gray-300/20 w-full"></div>
    <section class="flex justify-between w-full">
        <section class="flex">
            
            <div class="relative w-16 h-16 m-4 flex items-center justify-center text-2xl bg-white rounded-full shadow-md shadow-black">
                <span class="text-4xl"> {{ $_tempEmoji }} </span>
                <img src="/flags/{{ $country }}.png" alt="us"
                    class="absolute bottom-0 right-0 w-5 h-5 rounded-full border border-white" />
            </div>

            <section class="flex flex-col mt-4">
                <h5 class="font-bold">
                    {{ $name }}
                </h5>

                <div class="flex gap-1 text-md font-bold items-center mb-2">
                    <span> {{ $l1 }} </span>
                    <span> <x-tabler-transfer class="w-5 h-5 text-gray-200/40" /></span>
                    <span> {{ $l2 }} </span>
                </div>

                <p class="text-gray-100/60 font-light">
                    {{ $description }}
                </p>
            </section>
        </section>
        <button
            class="flex justify-center items-center bg-indigo-600 min-w-16 rounded-sm text-white/70 transition duration-200 hover:text-white active:scale-90">
            <x-tabler-user-plus class="w-7 h-7" />
        </button>
    </section>
</section>
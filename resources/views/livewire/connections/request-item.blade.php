<section class="flex flex-col items-start transition duration-150 ease-out hover:bg-gray-500/10">
    <div class="border-t border-gray-700 w-full"></div>
    <div class="flex justify-between w-full">
        <div class="flex">
            <div>
                <div
                    class="relative w-12 h-12 m-4 flex flex-shrink-0 items-center justify-center text-2xl bg-white rounded-full shadow-md shadow-black">
                    <span class="text-3xl"> {{ $_tempEmoji }} </span>
                    <img src="/flags/{{ $country }}.png" alt="us"
                        class="absolute bottom-0 right-0 w-4 h-4 rounded-full border border-white" />
                </div>

                <div class="flex items-center justify-center gap-1 my-1 -mt-3">
                    <div
                        class="h-1.5 w-1.5 rounded-full {{ $status == 'Offline' ? 'bg-gray-500' : ($status == 'Idle' ? 'bg-yellow-500' : 'bg-green-600') }}">
                    </div>
                    <p class="font-normal text-xs text-gray-200/90">{{ $status }}</p>
                </div>
            </div>

            <div class="flex flex-col mt-4">
                <div class="flex">
                    <h5 class="font-bold">
                        {{ $name }}
                    </h5>
                </div>

                <div class="flex gap-1 text-sm font-bold items-center mb-2">
                    <span> {{ $l1 }} </span>
                    <span> <x-tabler-transfer class="w-4 h-4 text-gray-200/40" /> </span>
                    <span> {{ $l2 }} </span>
                </div>
            </div>
        </div>
        <button wire:click="openProfile"
            class="flex flex-shrink-0 justify-center items-center bg-indigo-600 w-12 h-12 my-auto mx-4 rounded-full text-white/70 transition duration-150 ease-out hover:text-white active:scale-90 active:bg-indigo-500">
            <x-tabler-user-up class="w-7 h-7" />
        </button>
    </div>
</section>
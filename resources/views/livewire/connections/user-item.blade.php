<section class="flex flex-col items-start transition duration-150 ease-out hover:bg-gray-500/10">
    <div class="border-t border-base-300 w-full"></div>
    <div class="flex justify-between w-full">
        <div class="flex">
            <div>
                
                <!-- Avatar -->
                <div
                    class="relative w-16 h-16 m-4 flex flex-shrink-0 items-center justify-center text-2xl bg-primary rounded-full shadow">
                    @if ($avatarUrl)
                        <img src="{{ $avatarUrl }}" alt="{{ $user->name }}'s profile"
                            class="w-full h-full rounded-full shadow object-cover">
                    @else
                        <span class="text-2xl font-bold text-primary-content" >
                            {{ strtoupper(substr($name, 0, 1)) }}
                        </span>
                    @endif

                    <img src="{{ $flagUrl }}" alt="flag"
                        class="absolute bottom-0 right-0 w-5 h-5 object-cover rounded-full border border-white" />
                </div>
                
                <!-- *Status (Not implemented) -->
                <div class="flex items-center justify-center gap-1 my-1 -mt-3">
                    <div
                        class="h-1.5 w-1.5 rounded-full {{ $status == 'Online' ? 'bg-green-600' : ($status == 'Idle' ? 'bg-yellow-500' : 'bg-gray-500') }}">
                    </div>
                    <p class="font-normal text-xs text-gray-500 dark:text-gray-200/90">{{ $status }}</p>
                </div>
            </div>

            <!-- User Information -->
            <div class="flex flex-col mt-4">
                <div class="flex">
                    <h5 class="font-bold">
                        {{ $name }}
                    </h5>
                </div>

                <div class="flex gap-1 text-sm font-bold items-center mb-2">
                    <span> {{ $language1 }} </span>
                    <span> <x-tabler-transfer class="w-4 h-4 text-gray-500 dark:text-gray-200/40" /> </span>
                    <span> {{ $language2 }} </span>
                </div>

                <p class="text-gray-700 dark:text-gray-100/60 font-light">
                    {{ $description }}
                </p>
            </div>
        </div>

        <!-- Button for opening the user's profile -->
        <button wire:click="openProfile"
            class="flex flex-shrink-0 justify-center items-center bg-indigo-600 w-12 h-12 my-auto mx-4 rounded-full text-white/70 transition duration-150 ease-out hover:text-white active:scale-90 active:bg-indigo-500">
            <x-tabler-user-up class="w-7 h-7" />
        </button>
    </div>
</section>
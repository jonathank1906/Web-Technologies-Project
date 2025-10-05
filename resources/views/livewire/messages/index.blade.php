<div class="flex h-screen bg-[#f0f2f5] text-gray-800 font-sans">
    <!-- Left Column: Friends List -->
    <div class="w-1/3 bg-[#ffeaea] border-r border-gray-300 flex flex-col">
        <!-- Search Bar -->
        <div class="p-4 border-b border-gray-300 relative">
            <input type="text"
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                placeholder="Search friends..." />
            <i class="fas fa-plus absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
        </div>

        <!-- Friends List -->
        <div class="flex-1 overflow-y-auto px-4 pt-2 space-y-4">
            @foreach ([ 
                ['name' => 'Jonathan', 'flag' => 'us', 'img' => '🧔', 'lang' => 'EN <-> ES', 'last' => 'Hey! You ready to chat?'],
                ['name' => 'Lukas', 'flag' => 'de', 'img' => '👨‍🦱', 'lang' => 'DE <-> FR', 'last' => 'I sent you a message yesterday'],
                ['name' => 'Deivid', 'flag' => 'br', 'img' => '🧒', 'lang' => 'PT <-> EN', 'last' => 'Let’s learn together!'],
                ['name' => 'Benjamin', 'flag' => 'fr', 'img' => '👨‍🦰', 'lang' => 'FR <-> DE', 'last' => 'Bonjour! Ça va?'],
                ['name' => 'Daniils', 'flag' => 'lv', 'img' => '🧑', 'lang' => 'LV <-> EN', 'last' => 'Don’t forget our session!'],
            ] as $friend)
                <div
                    class="flex items-start gap-3 p-3 bg-white rounded-lg hover:bg-yellow-100 cursor-pointer transition shadow-sm">
                    <!-- Avatar -->
                    <div class="relative w-12 h-12 flex items-center justify-center text-2xl bg-white rounded-full shadow">
                        <span>{{ $friend['img'] }}</span>
                        <img src="/flags/{{ $friend['flag'] }}.png" alt="{{ strtoupper($friend['flag']) }}"
                             class="absolute bottom-0 right-0 w-4 h-4 rounded-full border border-white" />
                    </div>

                    <!-- Text Info -->
                    <div class="flex flex-col text-sm">
                        <span class="font-semibold text-gray-900 text-base">{{ $friend['name'] }}</span>
                        <span class="text-xs text-gray-600 italic">{{ $friend['lang'] }}</span>
                        <span class="text-xs text-gray-500 mt-1 truncate">{{ $friend['last'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Right Column: Chat Window -->
    <div class="w-2/3 flex flex-col">
        <!-- Chat Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-white shadow-sm">
            <div class="flex items-center gap-3">
                <div class="relative w-10 h-10 flex items-center justify-center text-xl bg-white rounded-full shadow">
                    <span>🧑</span>
                    <img src="/flags/lv.png" alt="LV"
                         class="absolute bottom-0 right-0 w-4 h-4 rounded-full border border-white" />
                </div>
                <div>
                    <h2 class="text-sm font-bold text-gray-800">Daniils</h2>
                    <p class="text-xs text-gray-500">LV <-> EN</p>
                </div>
            </div>

            <!-- Header Icons -->
            <div class="flex items-center gap-4 text-gray-600">
                <button title="Voice Call">
                    <i class="fas fa-phone-alt hover:text-green-600 transition"></i>
                </button>
                <button title="More Options">
                    <i class="fas fa-ellipsis-v hover:text-gray-800 transition"></i>
                </button>
            </div>
        </div>

        <!-- Chat Messages -->
        <div class="flex-1 overflow-y-auto px-6 py-4 space-y-3 bg-[#f5f6f8]">
            <div class="bg-gray-200 p-3 rounded max-w-sm">Hey, are you free to chat?</div>
            <div class="bg-blue-500 text-white p-3 rounded max-w-sm self-end ml-auto">Hi! Yes, just finished work.</div>
            <div class="bg-gray-200 p-3 rounded max-w-sm">Awesome! Let’s practice Lithuanian 😄</div>
            <div class="bg-blue-500 text-white p-3 rounded max-w-sm self-end ml-auto">Sure! Let's do it!</div>
        </div>

        <!-- Message Input -->
        <div class="px-6 py-4 border-t bg-white flex items-center gap-3">
            <button title="Emoji">
                <i class="far fa-smile text-gray-500 text-lg hover:text-yellow-500"></i>
            </button>
            <button title="Microphone">
                <i class="fas fa-microphone text-gray-500 text-lg hover:text-red-500"></i>
            </button>
            <button title="Attach File">
                <i class="fas fa-paperclip text-gray-500 text-lg hover:text-blue-500"></i>
            </button>
            <input type="text"
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                placeholder="Type a message..." />
            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Send</button>
        </div>
    </div>
</div>

<div class="drawer lg:drawer-open">
    <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
    <div class="drawer-side">
        <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
        <ul class="menu bg-base-200 text-base-content min-h-full w-50 p-4 pt-10 space-y-10">
            <li>
                <a href="/" class="flex items-center gap-5 hover:bg-base-300 transition-colors duration-200">
                    <!-- Home Icon -->
                    <x-monoicon-home class="w-8 h-8" />
                    <h4 x-cloak x-show="!(shrink||drawer)" class="text-lg font-medium">Home</h4>
                </a>
            </li>
            <li>
                <a href="{{ route('connections') }}" class="flex items-center gap-5 hover:bg-base-300 transition-colors duration-200">
                    <!-- Connections Icon -->
                    <x-tabler-wifi class="w-8 h-8" />
                    <h4 x-cloak x-show="!(shrink||drawer)" class="text-lg font-medium">Explore</h4>
                </a>
            </li>
            <li>
                <a href="{{ route('messages') }}" class="flex items-center gap-5 hover:bg-base-300 transition-colors duration-200">
                    <!-- Messages Icon -->
                    <x-tabler-messages class="w-8 h-8" />
                    <h4 x-cloak x-show="!(shrink||drawer)" class="text-lg font-medium">Messages</h4>
                </a>
            </li>
            <li>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-5 hover:bg-base-300 transition-colors duration-200">
                    <!-- Profile Icon -->
                    <x-css-profile class="w-8 h-8" />
                    <h4 x-cloak x-show="!(shrink||drawer)" class="text-lg font-medium">Profile</h4>
                </a>
            </li>
        </ul>
    </div>
</div>
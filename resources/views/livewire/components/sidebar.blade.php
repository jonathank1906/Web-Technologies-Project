<div class="drawer lg:drawer-open">
    <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
    <div class="drawer-side">
        <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
        <ul class="menu bg-base-200 text-base-content min-h-full w-50 p-4 pt-10 space-y-10">
            <li>
                <a class="flex items-center gap-5">
                    <!-- Home Icon -->
                    <x-monoicon-home class="w-8 h-8" />
                    <h4 x-cloak x-show="!(shrink||drawer)" class="text-lg font-medium">Home</h4>
                </a>
            </li>
            <li>
                <a class="flex items-center gap-5">
                    <!-- Connections Icon -->
                    <x-tabler-wifi class="w-8 h-8" />
                    <h4 x-cloak x-show="!(shrink||drawer)" class="text-lg font-medium">Explore</h4>
                </a>
            </li>
            <li>
                <a class="flex items-center gap-5">
                    <!-- Messages Icon -->
                    <x-tabler-messages class="w-8 h-8" />
                    <h4 x-cloak x-show="!(shrink||drawer)" class="text-lg font-medium">Messages</h4>
                </a>
            </li>
            <li>
                <div class="flex items-center gap-5">
                    <!-- Profile Icon -->
                    <x-css-profile class="w-8 h-8" />
                    <h4 x-cloak x-show="!(shrink||drawer)" class="text-lg font-medium">Profile</h4>
                </div>
            </li>
        </ul>
    </div>
</div>
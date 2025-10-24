<li class="sidebar-item cursor-pointer mt-auto">
    <x-dropdown>
        <!-- Button -->
        <x-slot name="trigger">
            <div class="sidebar-link">
                <x-tabler-menu class="sidebar-icon" />
                <span class="sidebar-text">{{ __('More') }}</span>
            </div>
        </x-slot>

        <!-- Dropdown Contents -->
        <x-slot name="content">
            @if(Auth::check())
                <!-- Username -->
                <h1 class="cursor-default block w-full px-4 py-2 text-start font-semibold text-md leading-5 text-gray-700 dark:text-gray-300">{{ Auth::user()->name }}</h1>

                <div class="border-t border-gray-300/20 w-full"></div>

                <!-- Settings Page -->
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Settings') }}
                </x-dropdown-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault();
                                                                                                                                                                                    this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            @else
                <x-dropdown-link :href="route('login')">
                    {{ __('Login') }}
                </x-dropdown-link>
            @endif
        </x-slot>
    </x-dropdown>
</li>
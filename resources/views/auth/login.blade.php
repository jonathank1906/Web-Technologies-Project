<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                <a class="text-sm text-gray-600 dark:text-gray-400 hover:underline hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
                @endif
            </div>
            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full pr-10"
                    type="password"
                    name="password"
                    required autocomplete="current-password" />
                <button type="button" id="togglePassword" class="absolute inset-y-0 end-0 flex items-center pr-3 focus:outline-none">
                    <span id="eyeOn" style="display:none;">
                        <x-monoicon-eye class="h-5 w-5 text-gray-500" />
                    </span>
                    <span id="eyeOff">
                        <x-monoicon-eye-off class="h-5 w-5 text-gray-500" />
                    </span>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-center mt-4">
            <x-primary-button class="w-full max-w-md flex justify-center items-center">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <!-- Register link -->
        <div class="flex flex-col items-center justify-center mt-4">
            <span class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                Don't have an account?
                @if (Route::has('register'))
                <a
                    href="{{ route('register') }}"
                    class="text-sm text-gray-600 dark:text-gray-400 hover:underline hover:text-indigo-800 dark:hover:text-indigo-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 ml-1">
                    Register
                </a>
                @endif
            </span>
        </div>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const togglePassword = document.getElementById("togglePassword");
            const password = document.getElementById("password");
            const eyeOn = document.getElementById("eyeOn");
            const eyeOff = document.getElementById("eyeOff");

            togglePassword.addEventListener("click", function() {
                const type = password.getAttribute("type") === "password" ? "text" : "password";
                password.setAttribute("type", type);

                if (type === "text") {
                    eyeOn.style.display = "";
                    eyeOff.style.display = "none";
                } else {
                    eyeOn.style.display = "none";
                    eyeOff.style.display = "";
                }
            });
        });
    </script>
</x-guest-layout>
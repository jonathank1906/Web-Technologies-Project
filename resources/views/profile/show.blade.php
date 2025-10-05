<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @include('profile.partials.user-info-header')

            <!-- About Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">About</h3>
                    <p class="text-gray-600 dark:text-gray-400">User bio and additional information will go here</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
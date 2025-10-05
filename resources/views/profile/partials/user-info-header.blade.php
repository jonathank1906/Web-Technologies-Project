<!-- Upper Section: Main User Info -->
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex items-center space-x-6">
            <!-- Profile Picture Placeholder -->
            <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                <span class="text-2xl font-bold text-white">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </span>
            </div>
            
            <!-- User Info -->
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $user->name }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    {{ $user->email }}
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-500 mt-2">
                    {{ __('Member since') }} {{ $user->created_at->format('F Y') }}
                </p>
            </div>

            <!-- Stats Section -->
            <div class="flex space-x-6 text-center">
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">0</p>
                    <p class="text-sm text-gray-500 dark:text-gray-500">Posts</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">0</p>
                    <p class="text-sm text-gray-500 dark:text-gray-500">Followers</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">0</p>
                    <p class="text-sm text-gray-500 dark:text-gray-500">Following</p>
                </div>
            </div>
        </div>
        
        <!-- Edit Profile Button -->
        <div class="mt-4 flex justify-end">
            <a href="{{ route('profile.edit') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-lg transition duration-150 ease-in-out shadow-sm hover:shadow-md">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Profile
            </a>
        </div>
    </div>
</div>
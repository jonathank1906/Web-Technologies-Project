<header class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 shadow rounded">
    <div class="p-6">
        <div class="flex items-center space-x-6">
            <figure class="w-20 h-20 bg-blue-500 rounded-full flex items-center justify-center">
                <span class="text-2xl font-bold text-white" aria-label="Profile avatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </span>
            </figure>
            
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $user->name }}
                </h1>
                <p class="text-gray-600 dark:text-gray-300 mt-1">
                    {{ $user->email }}
                </p>
                <time class="text-sm text-gray-500 dark:text-gray-400 mt-2 block" datetime="{{ $user->created_at->format('Y-m') }}">
                    {{ __('Member since') }} {{ $user->created_at->format('F Y') }}
                </time>
            </div>

            <aside class="flex space-x-6 text-center" aria-label="User statistics">
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">0</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Posts</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">0</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Followers</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">0</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Following</p>
                </div>
            </aside>
        </div>
        
        <nav class="mt-4 flex justify-end" aria-label="Profile actions">
            <a href="{{ route('profile.edit') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded shadow">
                Edit Profile
            </a>
        </nav>
    </div>
</header>
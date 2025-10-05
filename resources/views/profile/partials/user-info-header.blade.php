<!-- User Profile Header -->
<header class="bg-white shadow rounded">
    <div class="p-6">
        <div class="flex items-center space-x-6">
            <!-- Profile Picture -->
            <figure class="w-20 h-20 bg-blue-500 rounded-full flex items-center justify-center shadow">
                <span class="text-2xl font-bold text-white" aria-label="Profile avatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </span>
            </figure>
            
            <!-- User Information -->
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $user->name }}
                </h1>
                <p class="text-gray-600 mt-1">
                    {{ $user->email }}
                </p>
                <time class="text-sm text-gray-500 mt-2 block" datetime="{{ $user->created_at->format('Y-m') }}">
                    {{ __('Member since') }} {{ $user->created_at->format('F Y') }}
                </time>
            </div>

            <!-- User Statistics -->
            <aside class="flex space-x-6 text-center" aria-label="User statistics">
                <div>
                    <p class="text-2xl font-bold text-gray-900">0</p>
                    <p class="text-sm text-gray-500">Posts</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">0</p>
                    <p class="text-sm text-gray-500">Followers</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">0</p>
                    <p class="text-sm text-gray-500">Following</p>
                </div>
            </aside>
        </div>
        
        <!-- Profile Actions -->
        <nav class="mt-4 flex justify-end" aria-label="Profile actions">
            <a href="{{ route('profile.edit') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium text-sm rounded shadow">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Profile
            </a>
        </nav>
    </div>
</header>
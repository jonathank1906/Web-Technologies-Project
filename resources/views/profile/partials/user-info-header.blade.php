<header class="p-4 sm:p-8 bg-base-200 shadow sm:rounded-lg">
    <div class="p-6">
        <div class="flex items-center space-x-6">
            <figure class="w-20 h-20 rounded-full overflow-hidden flex items-center justify-center">
                @if($user->profile_picture && Storage::disk('public')->exists($user->profile_picture))
                    <img src="{{ Storage::url($user->profile_picture) }}" alt="{{ $user->name }}'s profile" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-primary rounded-full flex items-center justify-center">
                        <span class="text-2xl font-bold text-primary-content" aria-label="Profile avatar">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                    </div>
                @endif
            </figure>
            
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-base-content">
                    {{ $user->name }}
                </h1>
                <p class="text-base-content/70 mt-1">
                    {{ $user->email }}
                </p>
                <time class="text-sm text-base-content/50 mt-2 block" datetime="{{ $user->created_at->format('Y-m') }}">
                    {{ __('Member since') }} {{ $user->created_at->format('F Y') }}
                </time>
            </div>

            <aside class="flex space-x-6 text-center" aria-label="User statistics">
                <div>
                    <p class="text-2xl font-bold text-base-content">0</p>
                    <p class="text-sm text-base-content/50">Posts</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-base-content">0</p>
                    <p class="text-sm text-base-content/50">Followers</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-base-content">0</p>
                    <p class="text-sm text-base-content/50">Following</p>
                </div>
            </aside>
        </div>
        
        <nav class="mt-4 flex justify-end" aria-label="Profile actions">
            @if(auth()->user()->id === $user->id)
                <!-- Own profile - show edit button -->
                <button @click="$dispatch('edit-profile')" class="btn btn-primary">
                    Edit Profile
                </button>

            @else
                <!-- Other user's profile - show follow/message buttons -->
                <div class="flex space-x-3">
                    <button wire:click="follow" 
                            class="btn {{ $isFollowing ? 'btn-primary' : ($isPending ? 'btn-outline btn-secondary' : 'btn-outline btn-primary') }}">
                        {{ $isFollowing ? 'Following' : ($isPending ? 'Pending' : 'Follow') }}
                    </button>
                    <button wire:click="message"
                            class="btn btn-secondary">
                        <x-tabler-messages class="w-5 h-5 mr-2" /> Message
                    </button>
                </div>
            @endif
        </nav>
    </div>
</header>
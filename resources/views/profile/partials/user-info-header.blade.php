<header class="p-4 sm:p-8 bg-base-100 shadow sm:rounded-lg">
    <div class="p-6">
        <div class="flex items-center space-x-6">
            <div
                class="relative w-24 h-24 m-4 flex flex-shrink-0 items-center justify-center text-2xl bg-primary rounded-full shadow">
                @if ($user->getProfilePictureUrl())
                    <img src="{{ $user->getProfilePictureUrl() }}" alt="{{ $user->name }}'s profile"
                        class="w-full h-full rounded-full shadow object-cover">
                @else
                    <span class="text-4xl font-bold text-primary-content">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </span>
                @endif

                <img src="{{ $user->getFlagPictureUrl() }}" alt="flag"
                    class="absolute bottom-0.5 right-0.5 w-7 h-7 object-cover rounded-full border border-base-100 shadow" />
            </div>

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
                    <p class="text-2xl font-bold text-base-content">{{ $followers->count() }}</p>
                    <p class="text-sm text-base-content/50">Followers</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-base-content">{{ $following->count() }}</p>
                    <p class="text-sm text-base-content/50">Following</p>
                </div>
            </aside>
        </div>

        <nav class="mt-4 flex justify-end" aria-label="Profile actions">
            @auth
                @if (auth()->id() === $user->id)
                    <!-- Own profile - show edit button -->
                    <button @click="$dispatch('edit-profile')" class="btn btn-primary">
                        Edit Profile
                    </button>
                @else
                    <!-- Other user's profile - show follow/unfollow + message -->
                    <div class="flex space-x-3">
                        <form action="{{ $isFollowing ? route('profile.unfollow', $user) : route('profile.follow', $user) }}"
                            method="POST">
                            @csrf
                            @if($isFollowing)
                                @method('DELETE')
                                <button type="submit" class="btn btn-primary">Following</button>
                            @else
                                <button type="submit" class="btn btn-outline btn-primary">Follow</button>
                            @endif
                        </form>

                        @if ($isFollowing || $isFollowedBy)
                            <a href="{{ route('messages') }}" class="btn btn-secondary">
                                <x-tabler-messages class="w-5 h-5 mr-2" />
                                Message
                            </a>
                        @endif
                    </div>
                @endif
            @endauth

            @guest
                <!-- No actions for guests -->
                <!-- You can put an optional login button here later -->
            @endguest
        </nav>
    </div>
</header>

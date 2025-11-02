<section>
    <header>
        <h2 class="text-lg font-medium text-base-content">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-base-content">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="input input-bordered w-full mt-1" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="input input-bordered w-full mt-1" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-base-content">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="link text-sm">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-success">
                                {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="description" :value="__('Description')" />
            <textarea 
                id="description" 
                name="description" 
                class="textarea textarea-bordered w-full mt-1" 
                rows="4" 
                maxlength="1000"
                placeholder="{{ __('Tell us about yourself...') }}"
            >{{ old('description', $user->description) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('description')" />
            <p class="mt-1 text-sm text-base-content/60">
                {{ __('Maximum 1000 characters') }}
            </p>
        </div>

        <div>
            <x-input-label for="hobbies" :value="__('Hobbies & Interests')" />
            <x-text-input 
                id="hobbies" 
                name="hobbies" 
                type="text" 
                class="input input-bordered w-full mt-1" 
                :value="old('hobbies', $user->hobbies ? implode(', ', $user->hobbies) : '')" 
                maxlength="500"
                placeholder="{{ __('e.g. Reading, Gaming, Cooking, Travel') }}"
            />
            <x-input-error class="mt-2" :messages="$errors->get('hobbies')" />
            <p class="mt-1 text-sm text-base-content/60">
                {{ __('Separate multiple hobbies with commas. Maximum 500 characters total.') }}
            </p>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-base-content"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

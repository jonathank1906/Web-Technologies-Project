<x-app-layout>
    <header class="sticky top-0 backdrop-blur-md bg-base-200/10 shadow">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
            <h2 class="font-semibold text-xl text-base-content leading-tight">
                {{ __('Settings') }}
            </h2>
        </div>
    </header>

    <main class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Appearance Settings -->
            <section class="p-4 sm:p-8 bg-base-200 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.appearance-settings')
                </div>
            </section>

            <!-- Profile Information -->
            <section class="p-4 sm:p-8 bg-base-200 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </section>

            <!-- Password Update -->
            <section class="p-4 sm:p-8 bg-base-200 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </section>

            <!-- Account Deletion -->
            <section class="p-4 sm:p-8 bg-base-200 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </section>

        </div>
    </main>
</x-app-layout>

<x-app-layout>
    <header class="sticky top-0 backdrop-blur-md bg-base-200/10 shadow">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
            <h2 class="font-semibold text-xl text-base-content leading-tight">
                {{ __('Profile') }}
            </h2>
        </div>
    </header>

    <main class="py-12" x-data="{ tab: 'profile' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Tab Navigation -->
            <section class="bg-base-200 p-4 rounded-lg shadow">
                <nav class="flex space-x-6" role="tablist">
                    <button @click="tab = 'profile'"
                        :class="tab === 'profile' ? 'border-b-2 border-primary text-primary' : 'text-base-content/60'"
                        class="py-2 font-semibold focus:outline-none"
                        role="tab">
                        Profile
                    </button>
                    <button @click="tab = 'settings'"
                        :class="tab === 'settings' ? 'border-b-2 border-primary text-primary' : 'text-base-content/60'"
                        class="py-2 font-semibold focus:outline-none"
                        role="tab">
                        Settings
                    </button>
                    <button @click="tab = 'privacy'"
                        :class="tab === 'privacy' ? 'border-b-2 border-primary text-primary' : 'text-base-content/60'"
                        class="py-2 font-semibold focus:outline-none"
                        role="tab">
                        Privacy
                    </button>
                </nav>
            </section>

            <!-- Tab Panels -->
            <section class="bg-base-200 p-6 rounded-lg shadow space-y-6">

                <!-- Profile Tab Content -->
                <div x-show="tab === 'profile'" x-cloak role="tabpanel">
                    @include('profile.partials.user-info-header')

                    <section x-data="{ activeTab: 'about' }" class="mt-6">
                        <header class="border-b border-base-300">
                            <nav class="flex space-x-8 px-6" aria-label="Profile navigation" role="tablist">
                                <button @click="activeTab = 'about'" 
                                        :class="activeTab === 'about' ? 'border-primary text-primary' : 'border-transparent text-base-content/60'"
                                        class="py-4 px-1 border-b-2 font-medium text-sm"
                                        role="tab"
                                        :aria-selected="activeTab === 'about'"
                                        aria-controls="about-panel">
                                    About
                                </button>
                                <button @click="activeTab = 'followers'" 
                                        :class="activeTab === 'followers' ? 'border-primary text-primary' : 'border-transparent text-base-content/60'"
                                        class="py-4 px-1 border-b-2 font-medium text-sm"
                                        role="tab"
                                        :aria-selected="activeTab === 'followers'"
                                        aria-controls="followers-panel">
                                    Followers
                                </button>
                            </nav>
                        </header>

                        <div class="p-6">
                            <section x-show="activeTab === 'about'" 
                                     role="tabpanel"
                                     id="about-panel"
                                     aria-labelledby="about-tab">
                                @include('profile.partials.about-tab-content')
                            </section>

                            <section x-show="activeTab === 'followers'" 
                                     role="tabpanel"
                                     id="followers-panel"
                                     aria-labelledby="followers-tab">
                                @include('profile.partials.followers-tab-content')
                            </section>
                        </div>
                    </section>
                </div>

                <!-- Settings Tab Content -->
                <div x-show="tab === 'settings'" x-cloak role="tabpanel" class="space-y-10">
                    @include('profile.partials.appearance-settings')
                    @include('profile.partials.update-profile-information-form')
                </div>

                <!-- Privacy Tab Content -->
                <div x-show="tab === 'privacy'" x-cloak role="tabpanel" class="space-y-10">
                    @include('profile.partials.privacy-block-list')
                    @include('profile.partials.update-password-form')
                    @include('profile.partials.delete-user-form')
                </div>

            </section>
        </div>
    </main>
</x-app-layout>

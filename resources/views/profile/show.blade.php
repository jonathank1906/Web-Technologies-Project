<x-app-layout>
    <header class="sticky top-0 backdrop-blur-md bg-base-200/10 shadow">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
            <h2 class="font-semibold text-xl text-base-content leading-tight">
                {{ __('Profile') }}
            </h2>
        </div>
    </header>

    <main class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @include('profile.partials.user-info-header')

            <section x-data="{ activeTab: 'about' }" class="p-4 sm:p-8 bg-base-200 shadow sm:rounded-lg">
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
    </main>
</x-app-layout>
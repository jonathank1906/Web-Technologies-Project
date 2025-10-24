<x-app-layout>
    <main class="py-12">
        <div class="max-w-7xl mx-auto px-6 space-y-6">
            
            @include('profile.partials.user-info-header')

            <section x-data="{ activeTab: 'about' }" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 shadow rounded">
                <header class="border-b border-gray-200 dark:border-gray-600">
                    <nav class="flex space-x-8 px-6" aria-label="Profile navigation" role="tablist">
                        <button @click="activeTab = 'about'" 
                                :class="activeTab === 'about' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400'"
                                class="py-4 px-1 border-b-2 font-medium text-sm"
                                role="tab"
                                :aria-selected="activeTab === 'about'"
                                aria-controls="about-panel">
                            About
                        </button>
                        <button @click="activeTab = 'followers'" 
                                :class="activeTab === 'followers' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400'"
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
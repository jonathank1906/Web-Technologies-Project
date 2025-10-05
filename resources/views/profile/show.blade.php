<x-app-layout>
    <main class="py-12">
        <div class="max-w-7xl mx-auto px-6 space-y-6">
            
            @include('profile.partials.user-info-header')

            <!-- Profile content section -->
            <section x-data="{ activeTab: 'about' }" class="bg-white border shadow rounded">
                <!-- Tab navigation -->
                <header class="border-b">
                    <nav class="flex space-x-8 px-6" aria-label="Profile navigation" role="tablist">
                        <button @click="activeTab = 'about'" 
                                :class="activeTab === 'about' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500'"
                                class="py-4 px-1 border-b-2 font-medium text-sm"
                                role="tab"
                                :aria-selected="activeTab === 'about'"
                                aria-controls="about-panel">
                            About
                        </button>
                        <button @click="activeTab = 'followers'" 
                                :class="activeTab === 'followers' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500'"
                                class="py-4 px-1 border-b-2 font-medium text-sm"
                                role="tab"
                                :aria-selected="activeTab === 'followers'"
                                aria-controls="followers-panel">
                            Followers
                        </button>
                    </nav>
                </header>

                <!-- Tab Content -->
                <div class="p-6">
                    <!-- About Tab Panel -->
                    <section x-show="activeTab === 'about'" 
                             role="tabpanel"
                             id="about-panel"
                             aria-labelledby="about-tab">
                        @include('profile.partials.about-tab-content')
                    </section>

                    <!-- Followers Tab panel -->
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
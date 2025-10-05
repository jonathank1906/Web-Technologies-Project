<!-- About Tab Content -->
<article class="space-y-6">
    <!-- Main Profile Content -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Language Skills Section -->
        <section class="space-y-6">
            <!-- Teaching Languages -->
            <div>
                <h3 class="font-medium text-gray-900 mb-3">Teaches in:</h3>
                <ul class="flex flex-wrap gap-2" role="list">
                    <li class="px-3 py-2 bg-green-100 text-green-800 text-sm font-medium rounded flex items-center">
                        <span aria-hidden="true">🇺🇸</span> English
                    </li>
                    <li class="px-3 py-2 bg-green-100 text-green-800 text-sm font-medium rounded flex items-center">
                        <span aria-hidden="true">🇩🇪</span> German
                    </li>
                    <li class="px-3 py-2 bg-green-100 text-green-800 text-sm font-medium rounded flex items-center">
                        <span aria-hidden="true">🇪🇸</span> Spanish
                    </li>
                </ul>
            </div>

            <!-- Learning Languages -->
            <div>
                <h3 class="font-medium text-gray-900 mb-3">Learning:</h3>
                <ul class="flex flex-wrap gap-2" role="list">
                    <li class="px-3 py-2 bg-blue-100 text-blue-800 text-sm font-medium rounded flex items-center">
                        <span aria-hidden="true">🇫🇷</span> French
                    </li>
                    <li class="px-3 py-2 bg-blue-100 text-blue-800 text-sm font-medium rounded flex items-center">
                        <span aria-hidden="true">🇯🇵</span> Japanese
                    </li>
                </ul>
            </div>
        </section>

        <!-- Personal Description Section -->
        <section class="space-y-4">
            <h3 class="font-medium text-gray-900 mb-3">Personal Description</h3>
            <p class="text-gray-500 text-sm italic">
                I'm passionate about languages. I speak a few, teach a few, and want to learn a few.
            </p>
        </section>
    </div>

    <!-- Additional Information Section -->
    <footer class="pt-6 border-t">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Basic Information -->
            <section>
                <h3 class="font-medium text-gray-900 mb-3">Information</h3>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Location:</dt>
                        <dd class="text-gray-900">Vienna, Austria</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Joined:</dt>
                        <dd class="text-gray-900">
                            <time datetime="{{ $user->created_at->format('Y-m-d') }}">
                                {{ $user->created_at->format('F j, Y') }}
                            </time>
                        </dd>
                    </div>
                </dl>
            </section>
        </div>
    </footer>
</article>
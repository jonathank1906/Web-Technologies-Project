<article class="space-y-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <section class="space-y-6">
            <div>
                <h3 class="font-medium text-base-content mb-3">Teaches in:</h3>
                <ul class="flex flex-wrap gap-2" role="list">
                    <li class="px-3 py-2 bg-success/20 text-success text-sm font-medium rounded flex items-center">
                        <span aria-hidden="true">🇺🇸</span> English
                    </li>
                    <li class="px-3 py-2 bg-success/20 text-success text-sm font-medium rounded flex items-center">
                        <span aria-hidden="true">🇩🇪</span> German
                    </li>
                    <li class="px-3 py-2 bg-success/20 text-success text-sm font-medium rounded flex items-center">
                        <span aria-hidden="true">🇪🇸</span> Spanish
                    </li>
                </ul>
            </div>
            <div>
                <h3 class="font-medium text-base-content mb-3">Learning:</h3>
                <ul class="flex flex-wrap gap-2" role="list">
                    <li class="px-3 py-2 bg-info/20 text-info text-sm font-medium rounded flex items-center">
                        <span aria-hidden="true">🇫🇷</span> French
                    </li>
                    <li class="px-3 py-2 bg-info/20 text-info text-sm font-medium rounded flex items-center">
                        <span aria-hidden="true">🇯🇵</span> Japanese
                    </li>
                </ul>
            </div>
        </section>
        <section class="space-y-4">
            <h3 class="font-medium text-base-content mb-3">Personal Description</h3>
            <p class="text-base-content/70 text-sm italic">
                I'm passionate about languages. I speak a few, teach a few, and want to learn a few.
            </p>
        </section>
    </div>

    <footer class="pt-6 border-t border-base-300">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <section>
                <h3 class="font-medium text-base-content mb-3">Information</h3>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-base-content/60">Location:</dt>
                        <dd class="text-base-content">Vienna, Austria</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-base-content/60">Joined:</dt>
                        <dd class="text-base-content">
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
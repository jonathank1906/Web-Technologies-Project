<article class="space-y-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <section class="space-y-6">
            <div>
                <h3 class="font-medium text-base-content mb-3">Teaches in:</h3>
                @if(!empty($user->languages_teach))
                    <ul class="flex flex-wrap gap-2">
                        @foreach($user->languages_teach as $code)
                            <li
                                class="px-3 py-2 text-blue-600 bg-blue-100 dark:bg-blue-900/30 text-sm font-medium rounded-full flex items-center">
                                {{ config('languages')[$code] }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-base-content/50 text-sm italic">
                        No languages listed yet.
                    </p>
                @endif
            </div>
            <div>
                <h3 class="font-medium text-base-content mb-3">Learning:</h3>
                @if(!empty($user->languages_learn))
                    <ul class="flex flex-wrap gap-2">
                        @foreach($user->languages_learn as $code)
                            <li
                                class="px-3 py-2 text-amber-600 bg-amber-100 dark:bg-amber-900/30 text-sm font-medium rounded-full flex items-center">
                                {{ config('languages')[$code] }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-base-content/50 text-sm italic">
                        No languages listed yet.
                    </p>
                @endif
            </div>
        </section>

        <section class="space-y-6">
            <div>
                <h3 class="font-medium text-base-content mb-3">Personal Description</h3>
                @if($user->description)
                    <p class="text-base-content/80 text-sm">
                        {{ $user->description }}
                    </p>
                @else
                    <p class="text-base-content/50 text-sm italic">
                        No description provided yet.
                    </p>
                @endif
            </div>

            <div>
                <h3 class="font-medium text-base-content mb-3">Hobbies & Interests</h3>
                @if($user->hobbies && count($user->hobbies) > 0)
                    <div class="flex flex-wrap gap-2">
                        @foreach($user->hobbies as $hobby)
                            <span
                                class="px-3 py-1 text-teal-600 bg-teal-100 dark:bg-teal-900/30 text-sm font-medium rounded-full">
                                {{ $hobby }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <p class="text-base-content/50 text-sm italic">
                        No hobbies listed yet.
                    </p>
                @endif
            </div>
        </section>
    </div>

    <footer class="pt-6 border-t border-base-300">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <section>
                <h3 class="font-medium text-base-content mb-3">Information</h3>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-base-content/60">Location:</dt>
                        <dd class="text-base-content">{{ config('countries')[$user->location] ?? 'Not provided' }}</dd>
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
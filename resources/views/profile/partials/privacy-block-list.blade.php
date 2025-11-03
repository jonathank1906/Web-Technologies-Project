<section>
    <header>
        <h2 class="text-lg font-medium text-base-content">
            {{ __('Blocked Users') }}
        </h2>

        <p class="mt-1 text-sm text-base-content">
            {{ __("These users are currently blocked from interacting with you.") }}
        </p>
    </header>

    <div class="mt-6 space-y-4">
        <!-- Hardcoded example list -->
        <div class="bg-base-100 p-4 rounded-lg shadow flex justify-between items-center">
            <div>
                <p class="text-base-content font-medium">JaneDoe92</p>
                <p class="text-sm text-base-content/60">Blocked on Oct 30, 2025</p>
            </div>
            <button class="btn btn-outline btn-sm" disabled>
                Unblock
            </button>
        </div>

        <div class="bg-base-100 p-4 rounded-lg shadow flex justify-between items-center">
            <div>
                <p class="text-base-content font-medium">ToxicLinguist</p>
                <p class="text-sm text-base-content/60">Blocked on Sep 12, 2025</p>
            </div>
            <button class="btn btn-outline btn-sm" disabled>
                Unblock
            </button>
        </div>
    </div>

    <p class="text-sm text-base-content/60 mt-4 italic">Real functionality coming soon...</p>
</section>

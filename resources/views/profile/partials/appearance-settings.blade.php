<!-- resources/views/profile/partials/appearance-settings-form.blade.php -->
<section id="appearance">
	<header>
		<h2 class="text-lg font-medium text-base-content">
			{{ __('Appearance') }}
		</h2>
		<p class="mt-1 text-sm text-base-content">
			{{ __('Choose your theme preference.') }}
		</p>
	</header>

	<x-primary-button class="theme-toggle mt-6 inline-flex items-center px-3 py-2 rounded-md border text-sm text-base-content">
		<span class="theme-label">Toggle Light mode</span>
	 </x-primary-button>
</section>
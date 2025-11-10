<x-guest-layout>
    <!-- DaisyUI Steps -->
    <div class="flex justify-center">
        <ul class="steps steps-vertical lg:steps-horizontal mb-8 w-full max-w-2xl">
            <li class="step step-primary text-base-content" id="step1-indicator"></li>
            <li class="step text-base-content" id="step2-indicator"></li>
            <li class="step text-base-content" id="step3-indicator"></li>
            <li class="step text-base-content" id="step4-indicator"></li>
        </ul>
    </div>

    <form method="POST" action="{{ route('register') }}" id="registerForm">
        @csrf

        <!-- Step 1 -->
        <div id="step1" style="display:block;">
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-6">
                <button type="button" class="btn btn-primary" onclick="nextStep(1)">Next</button>
            </div>
        </div>

        <!-- Step 2 -->
        <div id="step2" style="display:none;">
            <div>
                <x-input-label for="birthday" :value="__('When is your birthday?')" />
                <x-text-input id="birthday" class="block mt-1 w-full" type="date" name="birthday" :value="old('birthday')" required />
                <x-input-error :messages="$errors->get('birthday')" class="mt-2" />
            </div>
            <div class="flex items-center justify-between mt-6">
                <button type="button" class="btn btn-secondary" onclick="prevStep(2)">Back</button>
                <button type="button" class="btn btn-primary" onclick="nextStep(2)">Next</button>
            </div>
        </div>

        <!-- Step 3 (VISIBLE FIRST) -->
        <div id="step3" style="display:none;">
            <div>
                <x-input-label for="languages_teach" :value="__('I speak (select up to 3)')" />
                <select id="languages_teach" name="languages_teach[]" class="js-example-basic-multiple block mt-1 w-full" multiple="multiple" required>
                    <option value="English">English</option>
                    <option value="Spanish">Spanish</option>
                    <option value="French">French</option>
                    <option value="German">German</option>
                    <option value="Chinese">Chinese</option>
                    <option value="Japanese">Japanese</option>
                    <option value="Arabic">Arabic</option>
                    <option value="Russian">Russian</option>
                    <option value="Portuguese">Portuguese</option>
                    <option value="Hindi">Hindi</option>
                </select>
                <x-input-error :messages="$errors->get('languages_teach')" class="mt-2" />
            </div>
            <div class="flex items-center justify-between mt-6">
                <button type="button" class="btn btn-secondary" onclick="prevStep(3)">Back</button>
                <button type="button" class="btn btn-primary" onclick="nextStep(3)">Next</button>
            </div>
        </div>

        <!-- Step 4 -->
        <div id="step4" style="display:none;">
            <div>
                <x-input-label for="languages_learn" :value="__('I want to learn (select up to 3)')" />
                <select id="languages_learn" name="languages_learn[]" class="js-example-basic-multiple block mt-1 w-full" multiple="multiple" required>
                    <option value="English">English</option>
                    <option value="Spanish">Spanish</option>
                    <option value="French">French</option>
                    <option value="German">German</option>
                    <option value="Chinese">Chinese</option>
                    <option value="Japanese">Japanese</option>
                    <option value="Arabic">Arabic</option>
                    <option value="Russian">Russian</option>
                    <option value="Portuguese">Portuguese</option>
                    <option value="Hindi">Hindi</option>
                </select>
                <x-input-error :messages="$errors->get('languages_learn')" class="mt-2" />
            </div>
            <div class="flex items-center justify-between mt-6">
                <button type="button" class="btn btn-secondary" onclick="prevStep(4)">Back</button>
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </div>

        <div class="flex items-center justify-center mt-4">
            <a class="text-sm text-gray-600 dark:text-gray-400 hover:underline hover:text-gray-900 dark:hover:text-gray-100"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
        </div>
    </form>

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <style>
        .select2-container--default .select2-selection--multiple {
            min-height: 45px;
            height: 45px;
            box-sizing: border-box;
            display: flex;
            align-items: center;
        }

        .select2-container--default .select2-selection--multiple .select2-search__field {
            height: 32px !important;
            margin-top: 0 !important;
            margin-bottom: 0 !important;
            align-self: center;
        }

        .select2-container {
            width: 100% !important;
        }

        /* Prevent unwanted scrollbars on the body */
        body {
            overflow-x: hidden;
        }

        /* Ensure Select2 dropdown doesn't overflow horizontally */
        .select2-dropdown {
            max-width: 100vw !important;
            box-sizing: border-box;
        }
    </style>

    <script>
        $(document).ready(function() {
            $(".js-example-basic-multiple").select2({
                placeholder: "Select languages",
                maximumSelectionLength: 3
            });
        });

        window.onload = function() {
            updateStepIndicator(1);
        };

        function validateStep1() {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;

            if (!name || !email || !password || !passwordConfirmation) {
                alert('Please fill in all fields');
                return false;
            }

            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                alert('Please enter a valid email address');
                return false;
            }

            if (password.length < 8) {
                alert('Password must be at least 8 characters long');
                return false;
            }

            if (password !== passwordConfirmation) {
                alert('Passwords do not match');
                return false;
            }

            return true;
        }

        function validateStep2() {
            const birthday = document.getElementById('birthday').value;
            if (!birthday) {
                alert('Please enter your birthday');
                return false;
            }
            return true;
        }

        function validateStep3() {
            const selectedLanguages = $('#languages_teach').val();
            if (!selectedLanguages || selectedLanguages.length === 0) {
                alert('Please select at least one language you speak');
                return false;
            }
            return true;
        }

        function validateStep4() {
            const selectedLanguages = $('#languages_learn').val();
            if (!selectedLanguages || selectedLanguages.length === 0) {
                alert('Please select at least one language you want to learn');
                return false;
            }
            return true;
        }

        function nextStep(current) {
            let isValid = false;

            if (current === 1) isValid = validateStep1();
            if (current === 2) isValid = validateStep2();
            if (current === 3) isValid = validateStep3();

            if (!isValid) return;

            document.getElementById('step' + current).style.display = 'none';
            document.getElementById('step' + (current + 1)).style.display = 'block';
            updateStepIndicator(current + 1);
        }

        function prevStep(current) {
            document.getElementById('step' + current).style.display = 'none';
            document.getElementById('step' + (current - 1)).style.display = 'block';
            updateStepIndicator(current - 1);
        }

        function updateStepIndicator(step) {
            for (let i = 1; i <= 4; i++) {
                const indicator = document.getElementById(`step${i}-indicator`);
                indicator.classList.toggle('step-primary', i <= step);
            }
        }

        document.getElementById('registerForm').addEventListener('submit', function(e) {
            if (!validateStep4()) {
                e.preventDefault();
            }
        });
    </script>
</x-guest-layout>
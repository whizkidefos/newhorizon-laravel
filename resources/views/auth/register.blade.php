@extends('layouts.auth')

@section('auth-content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Healthcare Professional Registration</h2>

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" x-data="{ nationality: '{{ old('nationality', '') }}' }">
                @csrf

                <!-- Personal Information Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Personal Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- First Name -->
                        <div>
                            <x-input-label for="first_name" :value="__('First Name')" />
                            <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name')" required autofocus />
                            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                        </div>

                        <!-- Last Name -->
                        <div>
                            <x-input-label for="last_name" :value="__('Last Name')" />
                            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name')" required />
                            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Mobile Phone -->
                        <div>
                            <x-input-label for="mobile_phone" :value="__('Mobile Phone')" />
                            <x-text-input id="mobile_phone" name="mobile_phone" type="tel" class="mt-1 block w-full" :value="old('mobile_phone')" required />
                            <x-input-error :messages="$errors->get('mobile_phone')" class="mt-2" />
                        </div>

                        <!-- Username -->
                        <div>
                            <x-input-label for="username" :value="__('Username')" />
                            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username')" required />
                            <x-input-error :messages="$errors->get('username')" class="mt-2" />
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <x-input-label for="dob" :value="__('Date of Birth')" />
                            <x-text-input id="dob" name="dob" type="date" class="mt-1 block w-full" :value="old('dob')" required />
                            <x-input-error :messages="$errors->get('dob')" class="mt-2" />
                        </div>

                        <!-- Gender -->
                        <div>
                            <x-input-label for="gender" :value="__('Gender')" />
                            <select id="gender" name="gender" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" required>
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />

                        <!-- Job Role -->
                        <div>
                            <x-input-label for="job_role" :value="__('Job Role')" />
                            <select id="job_role" name="job_role" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" required>
                                <option value="">Select Role</option>
                                <option value="registered_nurse" {{ old('job_role') == 'registered_nurse' ? 'selected' : '' }}>Registered Nurse</option>
                                <option value="healthcare_assistant" {{ old('job_role') == 'healthcare_assistant' ? 'selected' : '' }}>Healthcare Assistant</option>
                                <option value="support_worker" {{ old('job_role') == 'support_worker' ? 'selected' : '' }}>Support Worker</option>
                            </select>
                            <x-input-error :messages="$errors->get('job_role')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Address Information</h3>
                    <div class="space-y-4">
                        <div>
                            <x-input-label for="address_line_1" :value="__('Address Line 1')" />
                            <x-text-input id="address_line_1" name="address_line_1" type="text" class="mt-1 block w-full" :value="old('address_line_1')" required />
                            <x-input-error :messages="$errors->get('address_line_1')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="address_line_2" :value="__('Address Line 2')" />
                            <x-text-input id="address_line_2" name="address_line_2" type="text" class="mt-1 block w-full" :value="old('address_line_2')" />
                            <x-input-error :messages="$errors->get('address_line_2')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="city" :value="__('City')" />
                                <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city')" required />
                                <x-input-error :messages="$errors->get('city')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="postcode" :value="__('Postcode')" />
                                <x-text-input id="postcode" name="postcode" type="text" class="mt-1 block w-full" :value="old('postcode')" required />
                                <x-input-error :messages="$errors->get('postcode')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="country" :value="__('Country')" />
                                <x-text-input id="country" name="country" type="text" class="mt-1 block w-full" :value="old('country', 'United Kingdom')" required />
                                <x-input-error :messages="$errors->get('country')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Professional Information -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Professional Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- NI Number -->
                        <div>
                            <x-input-label for="ni_number" :value="__('National Insurance Number')" />
                            <x-text-input id="ni_number" name="ni_number" type="text" class="mt-1 block w-full" :value="old('ni_number')" required placeholder="AB123456C" />
                            <x-input-error :messages="$errors->get('ni_number')" class="mt-2" />
                        </div>

                        <!-- Nationality -->
                        <div>
                            <x-input-label for="nationality" :value="__('Nationality')" />
                            <select id="nationality" name="nationality" x-model="nationality" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" required>
                                <option value="">Select Nationality</option>
                                <option value="UK">British</option>
                                <option value="EU">EU Citizen</option>
                                <option value="Other">Other</option>
                            </select>
                            <x-input-error :messages="$errors->get('nationality')" class="mt-2" />
                        </div>

                        <!-- BRP Number (Only for non-UK nationals) -->
                        <div x-show="nationality === 'Other'" x-transition>
                            <x-input-label for="brp_number" :value="__('BRP Number')" />
                            <x-text-input id="brp_number" name="brp_number" type="text" class="mt-1 block w-full" :value="old('brp_number')" x-bind:required="nationality === 'Other'" />
                            <x-input-error :messages="$errors->get('brp_number')" class="mt-2" />
                        </div>

                        <!-- Right to Work -->
                        <div x-show="nationality !== 'UK'" x-transition>
                            <x-input-label for="right_to_work_doc" :value="__('Right to Work Document')" />
                            <input type="file" id="right_to_work_doc" name="right_to_work_doc" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" :required="nationality !== 'UK'" accept=".pdf,.jpg,.jpeg,.png" />
                            <x-input-error :messages="$errors->get('right_to_work_doc')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Password Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Account Security</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Terms and Privacy -->
                <div class="mb-8">
                    <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-md">
                        <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200">Data Protection Notice</h4>
                        <p class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                            By submitting this form, you agree to our processing of your personal data in accordance with our Privacy Policy. 
                            We collect and process your information to manage your application and comply with legal requirements. 
                            You have the right to access, correct, or delete your personal data at any time.
                        </p>
                    </div>

                    <div class="mt-4 space-y-4">
                        <label class="flex items-start">
                            <input type="checkbox" name="terms" required class="mt-1 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                                I agree to the <a href="{{ route('terms') }}" class="text-indigo-600 hover:text-indigo-500">Terms of Service</a> and 
                                <a href="{{ route('privacy') }}" class="text-indigo-600 hover:text-indigo-500">Privacy Policy</a>
                            </span>
                        </label>
                        <x-input-error :messages="$errors->get('terms')" class="mt-2" />

                        <label class="flex items-start">
                            <input type="checkbox" name="gdpr_consent" required class="mt-1 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                                I consent to New Horizon Healthcare processing my personal data as described in the Data Protection Notice.
                            </span>
                        </label>
                        <x-input-error :messages="$errors->get('gdpr_consent')" class="mt-2" />
                    </div>
                </div>

                <div class="flex items-center justify-end">
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button class="ml-4">
                        {{ __('Log In') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('registrationForm', () => ({
            nationality: '{{ old('nationality', '') }}',
            previewFile(event, previewId) {
                const file = event.target.files[0];
                if (!file) return;

                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const preview = document.getElementById(previewId);
                        preview.innerHTML = `<img src="${e.target.result}" class="max-h-32 rounded-md">`;
                    };
                    reader.readAsDataURL(file);
                } else {
                    const preview = document.getElementById(previewId);
                    preview.innerHTML = `<div class="p-2 bg-gray-100 rounded-md text-sm">${file.name}</div>`;
                }
            }
        }));
    });
</script>
@endpush
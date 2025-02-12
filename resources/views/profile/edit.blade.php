<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Edit Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('message'))
                        <div class="mb-4 rounded-md bg-green-50 dark:bg-green-900 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400 dark:text-green-300" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800 dark:text-green-200">
                                        {{ session('message') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($errors->has('error'))
                        <div class="mb-4 rounded-md bg-red-50 dark:bg-red-900 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400 dark:text-red-300" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-red-800 dark:text-red-200">
                                        {{ $errors->first('error') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{ nationality: '{{ old('nationality', $user->nationality) }}' }">
                        @csrf
                        @method('PATCH')

                        <!-- Personal Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Personal Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- First Name -->
                                <div>
                                    <x-input-label for="first_name" :value="__('First Name')" />
                                    <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $user->first_name)" required autofocus />
                                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                                </div>

                                <!-- Last Name -->
                                <div>
                                    <x-input-label for="last_name" :value="__('Last Name')" />
                                    <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $user->last_name)" required />
                                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                                </div>

                                <!-- Email -->
                                <div>
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <!-- Mobile Number -->
                                <div>
                                    <x-input-label for="mobile_number" :value="__('Mobile Number')" />
                                    <x-text-input id="mobile_number" name="mobile_number" type="tel" class="mt-1 block w-full" :value="old('mobile_number', $user->mobile_number)" required />
                                    <x-input-error :messages="$errors->get('mobile_number')" class="mt-2" />
                                </div>

                                <!-- Username -->
                                <div>
                                    <x-input-label for="username" :value="__('Username')" />
                                    <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username', $user->username)" required />
                                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                                </div>

                                <!-- Date of Birth -->
                                <div>
                                    <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                                    <x-text-input id="date_of_birth" name="date_of_birth" type="date" class="mt-1 block w-full" :value="old('date_of_birth', $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '')" required />
                                    <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                                </div>

                                <!-- Gender -->
                                <div>
                                    <x-input-label for="gender" :value="__('Gender')" />
                                    <select id="gender" name="gender" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" required>
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                        <option value="prefer_not_to_say" {{ old('gender', $user->gender) == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                                </div>

                                <!-- Job Role -->
                                <div>
                                    <x-input-label for="job_role" :value="__('Job Role')" />
                                    <select id="job_role" name="job_role" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" required>
                                        <option value="">Select Role</option>
                                        <option value="registered_nurse" {{ old('job_role', $user->job_role) == 'registered_nurse' ? 'selected' : '' }}>Registered Nurse</option>
                                        <option value="healthcare_assistant" {{ old('job_role', $user->job_role) == 'healthcare_assistant' ? 'selected' : '' }}>Healthcare Assistant</option>
                                        <option value="support_worker" {{ old('job_role', $user->job_role) == 'support_worker' ? 'selected' : '' }}>Support Worker</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('job_role')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Professional Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Professional Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- NI Number -->
                                <div>
                                    <x-input-label for="national_insurance_number" :value="__('National Insurance Number')" />
                                    <x-text-input id="national_insurance_number" name="national_insurance_number" type="text" class="mt-1 block w-full" :value="old('national_insurance_number', $user->national_insurance_number)" required placeholder="AB123456C" />
                                    <x-input-error :messages="$errors->get('national_insurance_number')" class="mt-2" />
                                </div>

                                <!-- Nationality -->
                                <div>
                                    <x-input-label for="nationality" :value="__('Nationality')" />
                                    <select id="nationality" name="nationality" x-model="nationality" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" required>
                                        <option value="">Select Nationality</option>
                                        <option value="British">British</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('nationality')" class="mt-2" />
                                </div>

                                <!-- Enhanced DBS -->
                                <div>
                                    <div class="flex items-center">
                                        <input id="has_enhanced_dbs" name="has_enhanced_dbs" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" value="1" {{ old('has_enhanced_dbs', $user->has_enhanced_dbs) ? 'checked' : '' }}>
                                        <label for="has_enhanced_dbs" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                                            {{ __('I have an Enhanced DBS Certificate') }}
                                        </label>
                                    </div>
                                    <x-input-error :messages="$errors->get('has_enhanced_dbs')" class="mt-2" />
                                </div>

                                <!-- Right to Work -->
                                <div>
                                    <div class="flex items-center">
                                        <input id="right_to_work_uk" name="right_to_work_uk" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" value="1" {{ old('right_to_work_uk', $user->right_to_work_uk) ? 'checked' : '' }}>
                                        <label for="right_to_work_uk" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                                            {{ __('I have the right to work in the UK') }}
                                        </label>
                                    </div>
                                    <x-input-error :messages="$errors->get('right_to_work_uk')" class="mt-2" />
                                </div>

                                <!-- Criminal Convictions -->
                                <div>
                                    <div class="flex items-center">
                                        <input id="has_criminal_convictions" name="has_criminal_convictions" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" value="1" {{ old('has_criminal_convictions', $user->has_criminal_convictions) ? 'checked' : '' }}>
                                        <label for="has_criminal_convictions" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                                            {{ __('I have criminal convictions') }}
                                        </label>
                                    </div>
                                    <x-input-error :messages="$errors->get('has_criminal_convictions')" class="mt-2" />
                                </div>

                                <!-- BRP Number (shown only if nationality is not British) -->
                                <div x-show="nationality && nationality !== 'British'">
                                    <x-input-label for="brp_number" :value="__('BRP Number')" />
                                    <x-text-input id="brp_number" name="brp_number" type="text" class="mt-1 block w-full" :value="old('brp_number', $user->brp_number)" />
                                    <x-input-error :messages="$errors->get('brp_number')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Documents -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Documents</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Profile Photo -->
                                <div>
                                    <x-input-label for="profile_photo" :value="__('Profile Photo')" />
                                    <input id="profile_photo" name="profile_photo" type="file" accept="image/*" class="mt-1 block w-full" />
                                    <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />
                                </div>

                                <!-- DBS Certificate -->
                                <div>
                                    <x-input-label for="dbs_certificate" :value="__('DBS Certificate')" />
                                    <input id="dbs_certificate" name="dbs_certificate" type="file" accept=".pdf,.jpg,.jpeg,.png" class="mt-1 block w-full" />
                                    <x-input-error :messages="$errors->get('dbs_certificate')" class="mt-2" />
                                </div>

                                <!-- BRP Document -->
                                <div x-show="nationality && nationality !== 'British'">
                                    <x-input-label for="brp_document" :value="__('BRP Document')" />
                                    <input id="brp_document" name="brp_document" type="file" accept=".pdf,.jpg,.jpeg,.png" class="mt-1 block w-full" />
                                    <x-input-error :messages="$errors->get('brp_document')" class="mt-2" />
                                </div>

                                <!-- Signature -->
                                <div>
                                    <x-input-label for="signature" :value="__('Signature')" />
                                    <input id="signature" name="signature" type="file" accept="image/*" class="mt-1 block w-full" />
                                    <x-input-error :messages="$errors->get('signature')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Update Profile') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

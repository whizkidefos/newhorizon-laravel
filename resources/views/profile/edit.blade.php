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
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{ nationality: '{{ old('nationality', $user->nationality) }}' }">
                        @csrf
                        @method('PUT')

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

                                <!-- Mobile Phone -->
                                <div>
                                    <x-input-label for="mobile_phone" :value="__('Mobile Phone')" />
                                    <x-text-input id="mobile_phone" name="mobile_phone" type="tel" class="mt-1 block w-full" :value="old('mobile_phone', $user->mobile_phone)" required />
                                    <x-input-error :messages="$errors->get('mobile_phone')" class="mt-2" />
                                </div>

                                <!-- Username -->
                                <div>
                                    <x-input-label for="username" :value="__('Username')" />
                                    <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username', $user->username)" required />
                                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                                </div>

                                <!-- Date of Birth -->
                                <div>
                                    <x-input-label for="dob" :value="__('Date of Birth')" />
                                    <x-text-input id="dob" name="dob" type="date" class="mt-1 block w-full" :value="old('dob', $user->dob ? $user->dob->format('Y-m-d') : '')" required />
                                    <x-input-error :messages="$errors->get('dob')" class="mt-2" />
                                </div>

                                <!-- Gender -->
                                <div>
                                    <x-input-label for="gender" :value="__('Gender')" />
                                    <select id="gender" name="gender" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" required>
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
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
                                    <x-input-label for="ni_number" :value="__('National Insurance Number')" />
                                    <x-text-input id="ni_number" name="ni_number" type="text" class="mt-1 block w-full" :value="old('ni_number', $user->ni_number)" required placeholder="AB123456C" />
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

                                <!-- Enhanced DBS -->
                                <div>
                                    <div class="flex items-center">
                                        <input type="checkbox" id="has_enhanced_dbs" name="has_enhanced_dbs" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" value="1" {{ old('has_enhanced_dbs', $user->has_enhanced_dbs) ? 'checked' : '' }}>
                                        <label for="has_enhanced_dbs" class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                                            I have Enhanced DBS with Update Service
                                        </label>
                                    </div>
                                    <x-input-error :messages="$errors->get('has_enhanced_dbs')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Address Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Address Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="address_line_1" :value="__('Address Line 1')" />
                                    <x-text-input id="address_line_1" name="address_line_1" type="text" class="mt-1 block w-full" :value="old('address_line_1', $user->profileDetail?->address_line_1)" required />
                                    <x-input-error :messages="$errors->get('address_line_1')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="address_line_2" :value="__('Address Line 2')" />
                                    <x-text-input id="address_line_2" name="address_line_2" type="text" class="mt-1 block w-full" :value="old('address_line_2', $user->profileDetail?->address_line_2)" />
                                    <x-input-error :messages="$errors->get('address_line_2')" class="mt-2" />
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <x-input-label for="city" :value="__('City')" />
                                        <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $user->profileDetail?->city)" required />
                                        <x-input-error :messages="$errors->get('city')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="postcode" :value="__('Postcode')" />
                                        <x-text-input id="postcode" name="postcode" type="text" class="mt-1 block w-full" :value="old('postcode', $user->profileDetail?->postcode)" required />
                                        <x-input-error :messages="$errors->get('postcode')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="country" :value="__('Country')" />
                                        <x-text-input id="country" name="country" type="text" class="mt-1 block w-full" :value="old('country', $user->profileDetail?->country ?? 'United Kingdom')" required />
                                        <x-input-error :messages="$errors->get('country')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Photo -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Profile Photo</h3>
                            <div class="flex items-center gap-4">
                                @if($user->profile_photo)
                                    <img src="{{ Storage::url($user->profile_photo) }}" alt="Profile Photo" class="w-32 h-32 rounded-full">
                                @else
                                    <div class="flex items-center justify-center w-32 h-32 bg-gray-200 rounded-full">
                                        <span class="text-4xl text-gray-500">{{ substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div>
                                    <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <x-secondary-button onclick="history.back()">
                                {{ __('Cancel') }}
                            </x-secondary-button>
                            <x-primary-button>
                                {{ __('Save Changes') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
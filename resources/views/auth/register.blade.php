@extends('layouts.auth')

@section('auth-content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Healthcare Professional Registration</h2>

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf

                <!-- Personal Information Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Personal Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- First Name -->
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                First Name
                            </label>
                            <input type="text" 
                                   name="first_name" 
                                   id="first_name" 
                                   value="{{ old('first_name') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                            @error('first_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Last Name -->
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Last Name
                            </label>
                            <input type="text" 
                                   name="last_name" 
                                   id="last_name" 
                                   value="{{ old('last_name') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                            @error('last_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Email Address
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mobile Phone -->
                        <div>
                            <label for="mobile_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Mobile Phone
                            </label>
                            <input type="tel" 
                                   name="mobile_phone" 
                                   id="mobile_phone" 
                                   value="{{ old('mobile_phone') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                            @error('mobile_phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Username -->
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Username
                            </label>
                            <input type="text" 
                                   name="username" 
                                   id="username" 
                                   value="{{ old('username') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                            @error('username')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Job Role -->
                        <div>
                            <label for="job_role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Job Role
                            </label>
                            <select name="job_role" 
                                    id="job_role"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    required>
                                <option value="">Select Role</option>
                                <option value="registered_nurse" {{ old('job_role') == 'registered_nurse' ? 'selected' : '' }}>
                                    Registered Nurse
                                </option>
                                <option value="healthcare_assistant" {{ old('job_role') == 'healthcare_assistant' ? 'selected' : '' }}>
                                    Healthcare Assistant
                                </option>
                                <option value="support_worker" {{ old('job_role') == 'support_worker' ? 'selected' : '' }}>
                                    Support Worker
                                </option>
                            </select>
                            @error('job_role')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Address Lookup Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Address Information</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="address_lookup" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Search Address
                            </label>
                            <input type="text" 
                                id="address_lookup" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Start typing your address...">
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Full Address
                            </label>
                            <input type="text" 
                                name="address" 
                                id="address" 
                                readonly
                                class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="postcode" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Postcode
                                </label>
                                <input type="text" 
                                    name="postcode" 
                                    id="postcode" 
                                    readonly
                                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm">
                            </div>

                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Country
                                </label>
                                <input type="text" 
                                    name="country" 
                                    id="country" 
                                    readonly
                                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Document Upload Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Required Documents</h3>
                    
                    <div x-data="{ showDBS: false }" class="space-y-4">
                        <!-- DBS Certificate -->
                        <div x-show="showDBS">
                            <label for="dbs_certificate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                DBS Certificate
                            </label>
                            <div class="mt-1 flex items-center">
                                <input type="file" 
                                    name="dbs_certificate" 
                                    id="dbs_certificate"
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                    @change="handleFileSelect($event, 'dbs_preview')">
                            </div>
                            <div id="dbs_preview" class="mt-2"></div>
                        </div>

                        <!-- Right to Work -->
                        <div>
                            <label for="right_to_work" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Right to Work Document
                            </label>
                            <div class="mt-1 flex items-center">
                                <input type="file" 
                                    name="right_to_work" 
                                    id="right_to_work"
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                    @change="handleFileSelect($event, 'rtw_preview')">
                            </div>
                            <div id="rtw_preview" class="mt-2"></div>
                        </div>
                    </div>
                </div>

                <!-- GDPR Consent -->
                <div class="mb-8">
                    <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-md">
                        <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200">Data Protection Notice</h4>
                        <p class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                            By submitting this form, you agree to our processing of your personal data in accordance with our Privacy Policy. We collect and process your information to manage your application and comply with legal requirements. You have the right to access, correct, or delete your personal data at any time.
                        </p>
                    </div>
                    
                    <div class="mt-4">
                        <label class="flex items-start">
                            <input type="checkbox" 
                                name="gdpr_consent" 
                                required
                                class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                                I consent to New Horizon Healthcare processing my personal data as described in the Data Protection Notice.
                            </span>
                        </label>
                        @error('gdpr_consent')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Professional Information Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Professional Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- NI Number -->
                        <div>
                            <label for="ni_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                National Insurance Number
                            </label>
                            <input type="text" 
                                   name="ni_number" 
                                   id="ni_number" 
                                   value="{{ old('ni_number') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                            @error('ni_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- DBS Status -->
                        <div>
                            <label for="dbs_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Do You Have Enhanced DBS with Update Service?
                            </label>
                            <select name="dbs_status" 
                                    id="dbs_status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    required>
                                <option value="">Select Option</option>
                                <option value="1" {{ old('dbs_status') == '1' ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ old('dbs_status') == '0' ? 'selected' : '' }}>No</option>
                            </select>
                            @error('dbs_status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Account Security -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Account Security</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Password
                            </label>
                            <input type="password" 
                                   name="password" 
                                   id="password"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Confirm Password
                            </label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   id="password_confirmation"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                        </div>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="mb-8">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" 
                                   name="terms" 
                                   id="terms"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                   required>
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="terms" class="font-medium text-gray-700 dark:text-gray-300">
                                I agree to the <a href="#" class="text-blue-600 hover:text-blue-500">Terms and Conditions</a>
                            </label>
                        </div>
                    </div>
                    @error('terms')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end">
                    <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-blue-500 mr-4">
                        Already registered?
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_key') }}&libraries=places"></script>
<script>
    // Google Places Autocomplete
    function initializeAutocomplete() {
        const input = document.getElementById('address_lookup');
        const autocomplete = new google.maps.places.Autocomplete(input, {
            componentRestrictions: { country: ['gb'] },
            fields: ['address_components', 'formatted_address', 'geometry']
        });

        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();
            if (!place.geometry) {
                return;
            }

            // Fill in address fields
            let postcode = '';
            let street = '';
            let city = '';
            let country = '';

            for (const component of place.address_components) {
                const type = component.types[0];
                
                if (type === 'postal_code') {
                    postcode = component.long_name;
                } else if (type === 'route') {
                    street = component.long_name;
                } else if (type === 'locality') {
                    city = component.long_name;
                } else if (type === 'country') {
                    country = component.long_name;
                }
            }

            document.getElementById('postcode').value = postcode;
            document.getElementById('address').value = place.formatted_address;
            document.getElementById('country').value = country;
        });
    }

    // File Upload Preview
    function handleFileSelect(event, previewId) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById(previewId);
                if (file.type.startsWith('image/')) {
                    preview.innerHTML = `<img src="${e.target.result}" class="max-h-32 rounded">`;
                } else {
                    preview.innerHTML = `<div class="p-4 bg-gray-100 dark:bg-gray-700 rounded">
                        <p class="text-sm">${file.name}</p>
                    </div>`;
                }
            };
            reader.readAsDataURL(file);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        initializeAutocomplete();
    });
</script>
@endpush
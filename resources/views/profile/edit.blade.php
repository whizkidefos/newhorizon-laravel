@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6 p-6">
                @csrf
                @method('PUT')

                <!-- Profile Photo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Profile Photo
                    </label>
                    <div class="flex items-center space-x-6">
                        <div class="shrink-0">
                            <img class="h-16 w-16 object-cover rounded-full"
                                 src="{{ $user->profile_photo ? Storage::url($user->profile_photo) : asset('images/default-avatar.png') }}"
                                 alt="{{ $user->full_name }}">
                        </div>
                        <label class="block">
                            <span class="sr-only">Choose profile photo</span>
                            <input type="file" 
                                   name="profile_photo" 
                                   class="block w-full text-sm text-gray-500
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-full file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-blue-50 file:text-blue-700
                                          hover:file:bg-blue-100">
                        </label>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            First Name
                        </label>
                        <input type="text" 
                               name="first_name" 
                               id="first_name" 
                               value="{{ old('first_name', $user->first_name) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Last Name
                        </label>
                        <input type="text" 
                               name="last_name" 
                               id="last_name" 
                               value="{{ old('last_name', $user->last_name) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Email
                        </label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email', $user->email) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="mobile_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Mobile Phone
                        </label>
                        <input type="tel" 
                               name="mobile_phone" 
                               id="mobile_phone" 
                               value="{{ old('mobile_phone', $user->mobile_phone) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Professional Information -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Professional Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="job_role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Job Role
                            </label>
                            <select name="job_role" 
                                    id="job_role"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="registered_nurse" {{ $user->job_role === 'registered_nurse' ? 'selected' : '' }}>
                                    Registered Nurse
                                </option>
                                <option value="healthcare_assistant" {{ $user->job_role === 'healthcare_assistant' ? 'selected' : '' }}>
                                    Healthcare Assistant
                                </option>
                                <option value="support_worker" {{ $user->job_role === 'support_worker' ? 'selected' : '' }}>
                                    Support Worker
                                </option>
                            </select>
                        </div>

                        <div>
                            <label for="ni_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                National Insurance Number
                            </label>
                            <input type="text" 
                                   name="ni_number" 
                                   id="ni_number" 
                                   value="{{ old('ni_number', $user->ni_number) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Documents Upload -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Documents</h3>
                    
                    <div class="space-y-4">
                        <!-- DBS Certificate -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                DBS Certificate
                            </label>
                            @if($user->dbs_certificate)
                                <div class="flex items-center space-x-2 mb-2">
                                    <span class="text-sm text-gray-500">Current file:</span>
                                    <a href="{{ Storage::url($user->dbs_certificate) }}" 
                                       class="text-blue-600 hover:text-blue-800 text-sm"
                                       target="_blank">
                                        View Certificate
                                    </a>
                                </div>
                            @endif
                            <input type="file" 
                                   name="dbs_certificate" 
                                   class="block w-full text-sm text-gray-500
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-full file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-blue-50 file:text-blue-700
                                          hover:file:bg-blue-100">
                        </div>

                        <!-- Right to Work -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Right to Work Documentation
                            </label>
                            <input type="file" 
                                   name="right_to_work_doc" 
                                   class="block w-full text-sm text-gray-500
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-full file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-blue-50 file:text-blue-700
                                          hover:file:bg-blue-100">
                        </div>

                        <!-- CV Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                CV
                            </label>
                            <input type="file" 
                                   name="cv" 
                                   class="block w-full text-sm text-gray-500
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-full file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-blue-50 file:text-blue-700
                                          hover:file:bg-blue-100">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <x-button type="submit" variant="primary">
                        Save Changes
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
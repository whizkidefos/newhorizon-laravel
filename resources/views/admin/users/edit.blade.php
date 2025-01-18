@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">
            Edit User: {{ $user->first_name }} {{ $user->last_name }}
        </h1>

        <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <!-- Personal Information -->
                <div class="space-y-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Personal Information</h2>
                    
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
                            @error('first_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
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
                            @error('last_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Add other personal information fields -->
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Contact Information</h2>
                    
                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Email address
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email"
                                   value="{{ old('email', $user->email) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="sm:col-span-3">
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
                </div>

                <!-- Professional Information -->
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Professional Information</h2>
                    
                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-3">
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
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <a href="{{ route('admin.users.show', $user) }}" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 rounded-md">
                        Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
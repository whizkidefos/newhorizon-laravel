<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit User: {{ $user->full_name }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6">
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
            <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')

                <!-- Personal Information -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Personal Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- First Name -->
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

                        <!-- Last Name -->
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

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Email Address
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email', $user->email) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
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
                                   value="{{ old('mobile_phone', $user->mobile_phone) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('mobile_phone')
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
                            @error('job_role')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Account Status -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Account Status</h3>
                    <div class="space-y-4">
                        <!-- Account Active Status -->
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   id="is_active"
                                   value="1"
                                   {{ $user->is_active ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Account Active
                            </label>
                        </div>

                        <!-- Email Verification -->
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="email_verified" 
                                   id="email_verified"
                                   value="1"
                                   {{ $user->email_verified_at ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="email_verified" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Email Verified
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Admin Notes</h3>
                    <textarea name="admin_notes" 
                              id="admin_notes"
                              rows="4"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('admin_notes', $user->admin_notes) }}</textarea>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-3">
                    <a href="{{ route('admin.users.show', $user) }}" 
                       class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
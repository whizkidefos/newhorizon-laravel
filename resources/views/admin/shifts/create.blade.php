<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
                Create New Shift
            </h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto my-12">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <form action="{{ route('admin.shifts.store') }}" method="POST" class="p-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Date & Time Section -->
                    <div class="col-span-2">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                            Shift Schedule
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Start DateTime -->
                            <div>
                                <label for="start_datetime" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Start Date & Time
                                </label>
                                <input type="datetime-local" 
                                       id="start_datetime" 
                                       name="start_datetime" 
                                       value="{{ old('start_datetime') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('start_datetime')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- End DateTime -->
                            <div>
                                <label for="end_datetime" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    End Date & Time
                                </label>
                                <input type="datetime-local" 
                                       id="end_datetime" 
                                       name="end_datetime" 
                                       value="{{ old('end_datetime') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('end_datetime')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="col-span-2">
                        <label for="location_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Location
                        </label>
                        <select id="location_id" 
                               name="location_id" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Select a location</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                    {{ $location->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('location_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Rate Per Hour -->
                    <div>
                        <label for="rate_per_hour" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Rate Per Hour (£)
                        </label>
                        <input type="number" 
                               id="rate_per_hour" 
                               name="rate_per_hour" 
                               value="{{ old('rate_per_hour') }}"
                               step="0.01"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('rate_per_hour')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Assign Staff (Optional) -->
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Assign Staff (Optional)
                        </label>
                        <select id="user_id" 
                                name="user_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Select Staff Member</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->full_name }} - {{ ucfirst($user->job_role) }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="col-span-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Notes
                        </label>
                        <textarea id="notes" 
                                  name="notes" 
                                  rows="3" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-6 flex items-center justify-end space-x-3">
                    <a href="{{ route('admin.shifts.index') }}" 
                       class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Create Shift
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
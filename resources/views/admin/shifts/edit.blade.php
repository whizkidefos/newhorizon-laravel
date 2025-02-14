<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
                Edit Shift
            </h2>
            <div class="flex space-x-4">
                <button type="button" 
                        onclick="document.getElementById('delete-form').submit();"
                        class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                    Delete Shift
                </button>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto p-8">
        <!-- Edit Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <form action="{{ route('admin.shifts.update', $shift) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Schedule Section -->
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
                                       value="{{ old('start_datetime', $shift->start_datetime->format('Y-m-d\TH:i')) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       {{ $shift->status !== 'open' ? 'disabled' : '' }}>
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
                                       value="{{ old('end_datetime', $shift->end_datetime->format('Y-m-d\TH:i')) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       {{ $shift->status !== 'open' ? 'disabled' : '' }}>
                                @error('end_datetime')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Location and Rate -->
                    <div class="col-span-2 md:col-span-1">
                        <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Location
                        </label>
                        <input type="text" 
                               id="location" 
                               name="location" 
                               value="{{ old('location', $shift->location) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               {{ $shift->status !== 'open' ? 'disabled' : '' }}>
                        @error('location')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="rate_per_hour" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Rate Per Hour (£)
                        </label>
                        <input type="number" 
                               id="rate_per_hour" 
                               name="rate_per_hour" 
                               value="{{ old('rate_per_hour', $shift->rate_per_hour) }}"
                               step="0.01"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('rate_per_hour')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-span-2">
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Status
                        </label>
                        <select id="status" 
                                name="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @foreach(['open', 'assigned', 'completed', 'cancelled'] as $status)
                                <option value="{{ $status }}" {{ old('status', $shift->status) === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
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
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notes', $shift->notes) }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-6 flex items-center justify-end space-x-3">
                    <a href="{{ route('admin.shifts.show', $shift) }}" 
                       class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Update Shift
                    </button>
                </div>
            </form>
        </div>

        <!-- Delete Form -->
        <form id="delete-form" action="{{ route('admin.shifts.destroy', $shift) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</x-admin-layout>
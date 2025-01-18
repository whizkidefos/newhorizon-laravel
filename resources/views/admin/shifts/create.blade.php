@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Create New Shift</h1>

        <form action="{{ route('admin.shifts.store') }}" method="POST" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Start Date & Time -->
                <div>
                    <label for="start_datetime" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Start Date & Time
                    </label>
                    <input type="datetime-local" 
                           name="start_datetime" 
                           id="start_datetime"
                           value="{{ old('start_datetime') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('start_datetime')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- End Date & Time -->
                <div>
                    <label for="end_datetime" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        End Date & Time
                    </label>
                    <input type="datetime-local" 
                           name="end_datetime" 
                           id="end_datetime"
                           value="{{ old('end_datetime') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('end_datetime')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div class="md:col-span-2">
                    <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Location
                    </label>
                    <input type="text" 
                           name="location" 
                           id="location"
                           value="{{ old('location') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rate Per Hour -->
                <div>
                    <label for="rate_per_hour" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Rate Per Hour (£)
                    </label>
                    <input type="number" 
                           name="rate_per_hour" 
                           id="rate_per_hour"
                           step="0.01"
                           value="{{ old('rate_per_hour') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('rate_per_hour')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Assign User (Optional) -->
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Assign Staff (Optional)
                    </label>
                    <select name="user_id" 
                            id="user_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Leave Unassigned</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->first_name }} {{ $user->last_name }} ({{ $user->job_role }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div class="md:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Notes
                    </label>
                    <textarea name="notes" 
                              id="notes"
                              rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a href="{{ route('admin.shifts.index') }}" 
                   class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 rounded-md">
                    Create Shift
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
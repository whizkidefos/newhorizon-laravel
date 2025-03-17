<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
                {{ __('Edit Complaint') }}
            </h2>
            <a href="{{ route('complaints.show', $complaint) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Back to Complaint') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 dark:bg-red-900/20 dark:text-red-300" role="alert">
                            <p class="font-bold">Error</p>
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif

                    <form action="{{ route('complaints.update', $complaint) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-6">
                            <x-input-label for="title" :value="__('Complaint Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $complaint->title)" required autofocus placeholder="Brief summary of the issue" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                        
                        <div class="mb-6">
                            <x-input-label for="severity" :value="__('Severity Level')" />
                            <select id="severity" name="severity" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="" disabled>Select severity level</option>
                                <option value="low" {{ old('severity', $complaint->severity) == 'low' ? 'selected' : '' }}>Low - Minor issue, no immediate action required</option>
                                <option value="medium" {{ old('severity', $complaint->severity) == 'medium' ? 'selected' : '' }}>Medium - Needs attention but not urgent</option>
                                <option value="high" {{ old('severity', $complaint->severity) == 'high' ? 'selected' : '' }}>High - Requires prompt attention</option>
                                <option value="critical" {{ old('severity', $complaint->severity) == 'critical' ? 'selected' : '' }}>Critical - Immediate action required</option>
                            </select>
                            <x-input-error :messages="$errors->get('severity')" class="mt-2" />
                        </div>
                        
                        <div class="mb-6">
                            <x-input-label for="shift_id" :value="__('Related Shift (Optional)')" />
                            <select id="shift_id" name="shift_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">No related shift</option>
                                @foreach(auth()->user()->shifts()->whereIn('status', ['completed'])->orderBy('date', 'desc')->get() as $shift)
                                    <option value="{{ $shift->id }}" {{ old('shift_id', $complaint->shift_id) == $shift->id ? 'selected' : '' }}>
                                        {{ $shift->date->format('M d, Y') }} - {{ $shift->location }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('shift_id')" class="mt-2" />
                        </div>
                        
                        <div class="mb-6">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="6" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required placeholder="Please provide detailed information about the issue, including what happened, when it occurred, who was involved, and any other relevant details.">{{ old('description', $complaint->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                        
                        <div class="flex items-center justify-between mt-6">
                            <a href="{{ route('complaints.show', $complaint) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Cancel
                            </a>
                            <x-primary-button class="bg-yellow-600 hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                </svg>
                                Update Complaint
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

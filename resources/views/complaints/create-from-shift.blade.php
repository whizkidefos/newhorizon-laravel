<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
                {{ __('Submit a Complaint for Your Shift') }}
            </h2>
            <a href="{{ route('shifts.checkout-options', $shift) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Back') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6 bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 text-blue-700 dark:text-blue-300 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-blue-700 dark:text-blue-300">Shift Information</h3>
                                <p class="mt-1"><span class="font-medium">Date:</span> {{ $shift->date }}</p>
                                <p class="mt-1"><span class="font-medium">Location:</span> {{ $shift->location }}</p>
                                <p class="mt-1"><span class="font-medium">Time:</span> {{ \Carbon\Carbon::parse($shift->checked_in_at)->format('h:i A') }} - {{ \Carbon\Carbon::parse($shift->checked_out_at)->format('h:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('complaints.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="shift_id" value="{{ $shift->id }}">
                        
                        <div class="mb-6">
                            <x-input-label for="title" :value="__('Complaint Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus placeholder="Brief summary of the issue" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                        
                        <div class="mb-6">
                            <x-input-label for="severity" :value="__('Severity Level')" />
                            <select id="severity" name="severity" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="" disabled selected>Select severity level</option>
                                <option value="low" {{ old('severity') == 'low' ? 'selected' : '' }}>Low - Minor issue, no immediate action required</option>
                                <option value="medium" {{ old('severity') == 'medium' ? 'selected' : '' }}>Medium - Needs attention but not urgent</option>
                                <option value="high" {{ old('severity') == 'high' ? 'selected' : '' }}>High - Requires prompt attention</option>
                                <option value="critical" {{ old('severity') == 'critical' ? 'selected' : '' }}>Critical - Immediate action required</option>
                            </select>
                            <x-input-error :messages="$errors->get('severity')" class="mt-2" />
                        </div>
                        
                        <div class="mb-6">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="6" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required placeholder="Please provide detailed information about the issue, including what happened, when it occurred, who was involved, and any other relevant details.">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                        
                        <div class="flex items-center justify-between mt-6">
                            <a href="{{ route('shifts.checkout-options', $shift) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Back
                            </a>
                            <x-primary-button class="bg-yellow-600 hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                                Submit Complaint
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Guidelines for Submitting a Complaint</h3>
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <span class="mr-2 text-yellow-600 dark:text-yellow-400">•</span>
                            <span><strong>Be specific</strong> - Include details about what happened, when, where, and who was involved.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2 text-yellow-600 dark:text-yellow-400">•</span>
                            <span><strong>Be factual</strong> - Stick to the facts and avoid emotional language.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2 text-yellow-600 dark:text-yellow-400">•</span>
                            <span><strong>Be constructive</strong> - If possible, suggest solutions or improvements.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2 text-yellow-600 dark:text-yellow-400">•</span>
                            <span><strong>Be professional</strong> - Maintain a professional tone throughout your complaint.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2 text-yellow-600 dark:text-yellow-400">•</span>
                            <span><strong>Be timely</strong> - Submit your complaint as soon as possible after the incident.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Work History') }}
            </h2>
            <button type="button" 
                    onclick="Livewire.emit('openModal', 'add-work-history')"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Add Work History
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($workHistory->isEmpty())
                        <div class="text-center">
                            <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No work history</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by adding your work history.</p>
                            <div class="mt-6">
                                <button type="button" 
                                        onclick="Livewire.emit('openModal', 'add-work-history')"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    Add Work History
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="flow-root">
                            <ul role="list" class="-mb-8">
                                @foreach($workHistory as $history)
                                    <li>
                                        <div class="relative pb-8">
                                            @if(!$loop->last)
                                                <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-600" aria-hidden="true"></span>
                                            @endif
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="flex items-center justify-center w-8 h-8 bg-blue-500 rounded-full ring-8 ring-white dark:ring-gray-800">
                                                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                                                            <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="text-sm">
                                                        <div class="flex items-center justify-between">
                                                            <div class="font-medium text-gray-900 dark:text-gray-100">{{ $history->company_name }}</div>
                                                            <div class="flex space-x-2">
                                                                <button type="button" 
                                                                        onclick="Livewire.emit('openModal', 'edit-work-history', {{ json_encode(['historyId' => $history->id]) }})"
                                                                        class="text-blue-600 hover:text-blue-800">
                                                                    Edit
                                                                </button>
                                                                <button type="button" 
                                                                        onclick="confirmDelete({{ $history->id }})"
                                                                        class="text-red-600 hover:text-red-800">
                                                                    Delete
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <p class="text-gray-500 dark:text-gray-400">{{ $history->job_title }}</p>
                                                    </div>
                                                    <div class="mt-1">
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                                            {{ $history->start_date->format('M Y') }} - 
                                                            {{ $history->end_date ? $history->end_date->format('M Y') : 'Present' }}
                                                        </div>
                                                    </div>
                                                    @if($history->responsibilities)
                                                        <div class="mt-2">
                                                            <div class="text-sm text-gray-700 dark:text-gray-300">
                                                                {{ $history->responsibilities }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($history->reference_name || $history->reference_contact)
                                                        <div class="mt-2">
                                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                                Reference: {{ $history->reference_name }}
                                                                @if($history->reference_contact)
                                                                    ({{ $history->reference_contact }})
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmDelete(historyId) {
            if (confirm('Are you sure you want to delete this work history entry?')) {
                Livewire.emit('deleteWorkHistory', historyId);
            }
        }
    </script>
    @endpush
</x-app-layout>

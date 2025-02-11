@extends('layouts.app')

@section('title', 'Work History')

@section('content')
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-2xl font-semibold">Work History</h1>
                        <button type="button" onclick="document.getElementById('add-history-modal').classList.remove('hidden')" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                            Add Work History
                        </button>
                    </div>

                    @if($workHistory->count() > 0)
                        <div class="space-y-6">
                            @foreach($workHistory as $history)
                                <div class="p-6 bg-white border rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <h3 class="text-lg font-semibold">{{ $history->company_name }}</h3>
                                            <p class="text-gray-600 dark:text-gray-400">{{ $history->job_title }}</p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button type="button" onclick="document.getElementById('edit-history-{{ $history->id }}').classList.remove('hidden')" class="px-3 py-1 text-sm text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                                Edit
                                            </button>
                                            <form action="{{ route('profile.work-history.destroy', $history->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 text-sm text-white bg-red-500 rounded-md hover:bg-red-600" onclick="return confirm('Are you sure you want to delete this work history?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="mt-4 space-y-2">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ \Carbon\Carbon::parse($history->start_date)->format('M Y') }} - 
                                            {{ $history->end_date ? \Carbon\Carbon::parse($history->end_date)->format('M Y') : 'Present' }}
                                        </p>
                                        <p class="text-gray-700 dark:text-gray-300">{{ $history->responsibilities }}</p>
                                        @if($history->reference_name)
                                            <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                                                <p><strong>Reference:</strong> {{ $history->reference_name }}</p>
                                                <p><strong>Contact:</strong> {{ $history->reference_contact }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Edit Work History Modal -->
                                <div id="edit-history-{{ $history->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
                                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                        <div class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl dark:bg-gray-800 sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                                            <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                                                <button type="button" onclick="document.getElementById('edit-history-{{ $history->id }}').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                                                    <span class="sr-only">Close</span>
                                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <form action="{{ route('profile.work-history.update', $history->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="space-y-4">
                                                    <div>
                                                        <label for="company_name_{{ $history->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Company Name</label>
                                                        <input type="text" name="company_name" id="company_name_{{ $history->id }}" value="{{ $history->company_name }}" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500">
                                                    </div>
                                                    <div>
                                                        <label for="job_title_{{ $history->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Job Title</label>
                                                        <input type="text" name="job_title" id="job_title_{{ $history->id }}" value="{{ $history->job_title }}" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500">
                                                    </div>
                                                    <div class="grid grid-cols-2 gap-4">
                                                        <div>
                                                            <label for="start_date_{{ $history->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
                                                            <input type="month" name="start_date" id="start_date_{{ $history->id }}" value="{{ \Carbon\Carbon::parse($history->start_date)->format('Y-m') }}" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500">
                                                        </div>
                                                        <div>
                                                            <label for="end_date_{{ $history->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Date</label>
                                                            <input type="month" name="end_date" id="end_date_{{ $history->id }}" value="{{ $history->end_date ? \Carbon\Carbon::parse($history->end_date)->format('Y-m') : '' }}" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500">
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label for="responsibilities_{{ $history->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Responsibilities</label>
                                                        <textarea name="responsibilities" id="responsibilities_{{ $history->id }}" rows="3" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500">{{ $history->responsibilities }}</textarea>
                                                    </div>
                                                    <div>
                                                        <label for="reference_name_{{ $history->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reference Name</label>
                                                        <input type="text" name="reference_name" id="reference_name_{{ $history->id }}" value="{{ $history->reference_name }}" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500">
                                                    </div>
                                                    <div>
                                                        <label for="reference_contact_{{ $history->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reference Contact</label>
                                                        <input type="text" name="reference_contact" id="reference_contact_{{ $history->id }}" value="{{ $history->reference_contact }}" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500">
                                                    </div>
                                                </div>
                                                <div class="mt-5 sm:mt-6">
                                                    <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm">
                                                        Update Work History
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{ $workHistory->links() }}
                    @else
                        <div class="p-4 text-center bg-gray-100 rounded-lg dark:bg-gray-700">
                            <p class="text-gray-600 dark:text-gray-400">No work history records found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Add Work History Modal -->
    <div id="add-history-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl dark:bg-gray-800 sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                    <button type="button" onclick="document.getElementById('add-history-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Close</span>
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form action="{{ route('profile.work-history.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Company Name</label>
                            <input type="text" name="company_name" id="company_name" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="job_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Job Title</label>
                            <input type="text" name="job_title" id="job_title" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
                                <input type="month" name="start_date" id="start_date" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Date</label>
                                <input type="month" name="end_date" id="end_date" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        <div>
                            <label for="responsibilities" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Responsibilities</label>
                            <textarea name="responsibilities" id="responsibilities" rows="3" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                        <div>
                            <label for="reference_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reference Name</label>
                            <input type="text" name="reference_name" id="reference_name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="reference_contact" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reference Contact</label>
                            <input type="text" name="reference_contact" id="reference_contact" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-6">
                        <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm">
                            Add Work History
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

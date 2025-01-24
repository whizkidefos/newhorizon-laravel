@extends('layouts.app')

@section('title', 'Bank Details')

@section('content')
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-2xl font-semibold">Bank Details</h1>
                        @if(!$bankDetails)
                            <button type="button" onclick="document.getElementById('add-bank-modal').classList.remove('hidden')" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                Add Bank Details
                            </button>
                        @endif
                    </div>

                    @if($bankDetails)
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div>
                                    <h3 class="text-lg font-medium">Bank Name</h3>
                                    <p class="mt-1">{{ $bankDetails->bank_name }}</p>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium">Account Name</h3>
                                    <p class="mt-1">{{ $bankDetails->account_name }}</p>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium">Account Number</h3>
                                    <p class="mt-1">{{ $bankDetails->account_number }}</p>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium">Sort Code</h3>
                                    <p class="mt-1">{{ $bankDetails->sort_code }}</p>
                                </div>
                            </div>

                            <div class="flex justify-end mt-6">
                                <button type="button" onclick="document.getElementById('edit-bank-modal').classList.remove('hidden')" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                    Edit Details
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="p-4 text-center bg-gray-100 rounded-lg dark:bg-gray-700">
                            <p class="text-gray-600 dark:text-gray-400">No bank details have been added yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Add Bank Details Modal -->
    <div id="add-bank-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl dark:bg-gray-800 sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                    <button type="button" onclick="document.getElementById('add-bank-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Close</span>
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form action="{{ route('profile.bank-details.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="bank_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bank Name</label>
                            <input type="text" name="bank_name" id="bank_name" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="account_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Account Name</label>
                            <input type="text" name="account_name" id="account_name" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="account_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Account Number</label>
                            <input type="text" name="account_number" id="account_number" required pattern="[0-9]{8}" title="Please enter a valid 8-digit account number" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="sort_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sort Code</label>
                            <input type="text" name="sort_code" id="sort_code" required pattern="[0-9-]{6,8}" title="Please enter a valid sort code (e.g., 12-34-56)" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-6">
                        <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm">
                            Save Bank Details
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if($bankDetails)
        <!-- Edit Bank Details Modal -->
        <div id="edit-bank-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl dark:bg-gray-800 sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                        <button type="button" onclick="document.getElementById('edit-bank-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Close</span>
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <form action="{{ route('profile.bank-details.update', $bankDetails->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label for="edit_bank_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bank Name</label>
                                <input type="text" name="bank_name" id="edit_bank_name" value="{{ $bankDetails->bank_name }}" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="edit_account_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Account Name</label>
                                <input type="text" name="account_name" id="edit_account_name" value="{{ $bankDetails->account_name }}" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="edit_account_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Account Number</label>
                                <input type="text" name="account_number" id="edit_account_number" value="{{ $bankDetails->account_number }}" required pattern="[0-9]{8}" title="Please enter a valid 8-digit account number" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="edit_sort_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sort Code</label>
                                <input type="text" name="sort_code" id="edit_sort_code" value="{{ $bankDetails->sort_code }}" required pattern="[0-9-]{6,8}" title="Please enter a valid sort code (e.g., 12-34-56)" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        <div class="mt-5 sm:mt-6">
                            <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm">
                                Update Bank Details
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection

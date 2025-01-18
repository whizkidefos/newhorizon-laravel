@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Document Review</h1>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                Pending Documents
            </h3>
        </div>

        <div class="border-t border-gray-200 dark:border-gray-700">
            @forelse($pendingDocuments as $document)
                <div class="px-4 py-5 sm:p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-2">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white">
                                        {{ $document->type }}
                                    </h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Submitted by: {{ $document->user->full_name }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Uploaded: {{ $document->created_at->format('d M Y, H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 md:mt-0 md:col-span-1">
                            <div class="space-y-4">
                                <a href="{{ Storage::url($document->file_path) }}" 
                                   target="_blank"
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    View Document
                                </a>

                                <button @click="$dispatch('open-modal', 'verify-document-{{ $document->id }}')"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                    Verify Document
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Verification Modal -->
                    <x-modal name="verify-document-{{ $document->id }}">
                        <form action="{{ route('admin.documents.verify', $document) }}" method="POST">
                            @csrf
                            <div class="p-6">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                                    Verify Document
                                </h2>

                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Status
                                        </label>
                                        <select name="status" 
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <option value="approved">Approve</option>
                                            <option value="rejected">Reject</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Expiry Date
                                        </label>
                                        <input type="date" 
                                               name="expires_at"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Notes
                                        </label>
                                        <textarea name="notes"
                                                  rows="3"
                                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="submit"
                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Submit Verification
                                </button>
                                <button type="button"
                                        @click="$dispatch('close')"
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </x-modal>
                </div>
            @empty
                <div class="px-4 py-5 sm:p-6 text-center text-gray-500 dark:text-gray-400">
                    No documents pending review.
                </div>
            @endforelse
        </div>
    </div>

    <div class="mt-6">
        {{ $pendingDocuments->links() }}
    </div>
</div>
@endsection
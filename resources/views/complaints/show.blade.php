<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
                {{ __('Complaint Details') }}
            </h2>
            <a href="{{ route('complaints.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Back to Complaints') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 dark:bg-green-900 dark:text-green-200" role="alert">
                            <p class="font-bold">Success</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Complaint #{{ $complaint->id }}</h3>
                        <div class="flex space-x-2">
                            @if($complaint->status === 'open')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                    Open
                                </span>
                            @elseif($complaint->status === 'in_progress')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100">
                                    In Progress
                                </span>
                            @elseif($complaint->status === 'resolved')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                    Resolved
                                </span>
                            @elseif($complaint->status === 'closed')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                    Closed
                                </span>
                            @endif
                            
                            @if($complaint->severity === 'low')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                    Low Severity
                                </span>
                            @elseif($complaint->severity === 'medium')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">
                                    Medium Severity
                                </span>
                            @elseif($complaint->severity === 'high')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                                    High Severity
                                </span>
                            @elseif($complaint->severity === 'critical')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-800 text-white dark:bg-gray-900 dark:text-gray-100">
                                    Critical Severity
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow overflow-hidden mb-6">
                        <div class="px-4 py-3 bg-gray-100 dark:bg-gray-600 border-b border-gray-200 dark:border-gray-800">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $complaint->title }}</h3>
                        </div>
                        <div class="p-4">
                            <div class="mb-4">
                                <div class="flex justify-between text-sm text-gray-500 dark:text-gray-400 mb-2">
                                    <span>Submitted: {{ $complaint->created_at->format('M d, Y g:i A') }}</span>
                                    @if($complaint->created_at != $complaint->updated_at)
                                        <span>Updated: {{ $complaint->updated_at->format('M d, Y g:i A') }}</span>
                                    @endif
                                </div>
                                <div class="p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                    {!! nl2br(e($complaint->description)) !!}
                                </div>
                            </div>

                            @if($complaint->shift)
                                <div class="mt-6">
                                    <h4 class="text-md font-medium border-b pb-2 mb-3 border-gray-200 dark:border-gray-700">Related Shift</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <p class="mb-1 text-sm"><span class="font-medium">Date:</span> {{ $complaint->shift->date->format('M d, Y') }}</p>
                                            <p class="mb-1 text-sm"><span class="font-medium">Location:</span> {{ $complaint->shift->location }}</p>
                                        </div>
                                        <div>
                                            <p class="mb-1 text-sm"><span class="font-medium">Check-in:</span> {{ $complaint->shift->checked_in_at ? \Carbon\Carbon::parse($complaint->shift->checked_in_at)->format('g:i A') : 'N/A' }}</p>
                                            <p class="mb-1 text-sm"><span class="font-medium">Check-out:</span> {{ $complaint->shift->checked_out_at ? \Carbon\Carbon::parse($complaint->shift->checked_out_at)->format('g:i A') : 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($complaint->status === 'resolved' || $complaint->status === 'closed')
                        <div class="bg-green-50 dark:bg-green-900/20 rounded-lg shadow overflow-hidden mb-6 border border-green-200 dark:border-green-800">
                            <div class="px-4 py-3 bg-green-100 dark:bg-green-800/30 border-b border-green-200 dark:border-green-800">
                                <h3 class="text-lg font-medium text-green-800 dark:text-green-100">Resolution</h3>
                            </div>
                            <div class="p-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Resolved on: {{ $complaint->resolved_at ? \Carbon\Carbon::parse($complaint->resolved_at)->format('M d, Y g:i A') : 'N/A' }}</p>
                                <div class="p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                    {!! nl2br(e($complaint->resolution_notes)) ?: '<span class="text-gray-500 dark:text-gray-400">No resolution notes provided.</span>' !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="flex justify-between mt-6">
                        <div class="flex space-x-2">
                            @if($complaint->status === 'open')
                                <a href="{{ route('complaints.edit', $complaint) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit Complaint
                                </a>
                                
                                <form action="{{ route('complaints.destroy', $complaint) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this complaint?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                        <a href="{{ route('complaints.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Complaints
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

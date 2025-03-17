<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Timesheet Details') }}
            </h2>
            <div>
                <a href="{{ route('admin.timesheets.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-600 focus:bg-gray-700 dark:focus:bg-gray-600 active:bg-gray-900 dark:active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Back to Timesheets') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <h5 class="mb-0">Timesheet Information</h5>
                                <p><strong>ID:</strong> #{{ $timesheet->id }}</p>
                                <p>
                                    <strong>Status:</strong>
                                    @if($timesheet->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($timesheet->status == 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($timesheet->status == 'rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($timesheet->status) }}</span>
                                    @endif
                                </p>
                                <p><strong>Date:</strong> {{ $timesheet->date->format('M d, Y') }}</p>
                                <p><strong>Start Time:</strong> {{ \Carbon\Carbon::parse($timesheet->start_time)->format('h:i A') }}</p>
                                <p><strong>End Time:</strong> {{ \Carbon\Carbon::parse($timesheet->end_time)->format('h:i A') }}</p>
                                <p><strong>Hours Worked:</strong> {{ number_format($timesheet->hours_worked, 2) }}</p>
                                <p><strong>Break Duration:</strong> {{ number_format($timesheet->break_duration, 2) }} hours</p>
                                <p><strong>Submitted:</strong> {{ $timesheet->created_at->format('M d, Y g:i A') }}</p>
                                @if($timesheet->status == 'approved')
                                    <p><strong>Approved:</strong> {{ $timesheet->approved_at ? \Carbon\Carbon::parse($timesheet->approved_at)->format('M d, Y g:i A') : 'N/A' }}</p>
                                @elseif($timesheet->status == 'rejected')
                                    <p><strong>Rejected:</strong> {{ $timesheet->rejected_at ? \Carbon\Carbon::parse($timesheet->rejected_at)->format('M d, Y g:i A') : 'N/A' }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <h5 class="mb-0">Employee Information</h5>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3">
                                        @if($timesheet->user->profile_photo_path)
                                            <img src="{{ Storage::url($timesheet->user->profile_photo_path) }}" alt="{{ $timesheet->user->name }}" class="rounded-circle" width="60" height="60">
                                        @else
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                {{ strtoupper(substr($timesheet->user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h5 class="mb-1">{{ $timesheet->user->name }}</h5>
                                        <p class="mb-0 text-muted">{{ $timesheet->user->email }}</p>
                                    </div>
                                </div>
                                <p><strong>Employee ID:</strong> {{ $timesheet->user->id }}</p>
                                <p><strong>Position:</strong> {{ $timesheet->user->position ?? 'N/A' }}</p>
                                <p><strong>Department:</strong> {{ $timesheet->user->department ?? 'N/A' }}</p>
                                <p><strong>Phone:</strong> {{ $timesheet->user->phone ?? 'N/A' }}</p>
                                <a href="{{ route('admin.users.show', $timesheet->user) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-user me-1"></i> View Employee Profile
                                </a>
                            </div>
                        </div>
                    </div>

                    @if($timesheet->shift)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <h5 class="mb-0">Related Shift</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Shift ID:</strong> #{{ $timesheet->shift->id }}</p>
                                        <p><strong>Date:</strong> {{ $timesheet->shift->date->format('M d, Y') }}</p>
                                        <p><strong>Location:</strong> {{ $timesheet->shift->location }}</p>
                                        <p><strong>Position:</strong> {{ $timesheet->shift->position }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Check-in:</strong> {{ $timesheet->shift->checked_in_at ? \Carbon\Carbon::parse($timesheet->shift->checked_in_at)->format('M d, Y g:i A') : 'N/A' }}</p>
                                        <p><strong>Check-out:</strong> {{ $timesheet->shift->checked_out_at ? \Carbon\Carbon::parse($timesheet->shift->checked_out_at)->format('M d, Y g:i A') : 'N/A' }}</p>
                                        <p><strong>Status:</strong> {{ ucfirst($timesheet->shift->status) }}</p>
                                        <a href="{{ route('admin.shifts.show', $timesheet->shift) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-calendar-alt me-1"></i> View Shift Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <h5 class="mb-0">Tasks Completed</h5>
                                <div class="p-3 bg-light rounded">
                                    {!! nl2br(e($timesheet->tasks_completed)) ?: '<span class="text-muted">No tasks specified</span>' !!}
                                </div>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <h5 class="mb-0">Additional Notes</h5>
                                <div class="p-3 bg-light rounded">
                                    {!! nl2br(e($timesheet->notes)) ?: '<span class="text-muted">No additional notes</span>' !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($timesheet->status == 'rejected' && $timesheet->rejection_reason)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 border border-danger">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <h5 class="mb-0">Rejection Reason</h5>
                                <div class="p-3 bg-light rounded">
                                    {!! nl2br(e($timesheet->rejection_reason)) !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="flex justify-between mt-6">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.timesheets.edit', $timesheet) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-600 focus:bg-blue-700 dark:focus:bg-blue-600 active:bg-blue-900 dark:active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                {{ __('Edit Timesheet') }}
                            </a>
                            @if($timesheet->status == 'pending')
                                <form action="{{ route('admin.timesheets.approve', $timesheet) }}" method="POST" class="d-inline me-2">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check me-1"></i> Approve
                                    </button>
                                </form>
                                <button type="button" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                    <i class="fas fa-times me-1"></i> Reject
                                </button>
                            @endif
                            <form action="{{ route('admin.timesheets.destroy', $timesheet) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this timesheet?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-trash me-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" x-data>
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.timesheets.reject', $timesheet) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectModalLabel">Reject Timesheet</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="rejection_reason" class="form-label">Reason for Rejection</label>
                            <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required></textarea>
                            <div class="form-text">Please provide a clear reason for rejecting this timesheet. This will be visible to the employee.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Reject Timesheet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

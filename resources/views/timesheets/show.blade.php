<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Timesheet Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                        <h4 class="mb-0">Timesheet Details</h4>
                                        <a href="{{ route('timesheets.index') }}" class="btn btn-light">
                                            <i class="fas fa-arrow-left me-1"></i> Back to Timesheets
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        @if(session('success'))
                                            <div class="alert alert-success">
                                                {{ session('success') }}
                                            </div>
                                        @endif

                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h5 class="border-bottom pb-2 mb-3">Timesheet Information</h5>
                                                <p><strong>Date:</strong> {{ $timesheet->date->format('M d, Y') }}</p>
                                                <p><strong>Start Time:</strong> {{ \Carbon\Carbon::parse($timesheet->start_time)->format('h:i A') }}</p>
                                                <p><strong>End Time:</strong> {{ \Carbon\Carbon::parse($timesheet->end_time)->format('h:i A') }}</p>
                                                <p><strong>Hours Worked:</strong> {{ number_format($timesheet->hours_worked, 2) }}</p>
                                                <p><strong>Break Duration:</strong> {{ number_format($timesheet->break_duration, 2) }} hours</p>
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
                                                <p><strong>Submitted:</strong> {{ $timesheet->created_at->format('M d, Y g:i A') }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h5 class="border-bottom pb-2 mb-3">Shift Details</h5>
                                                @if($timesheet->shift)
                                                    <p><strong>Location:</strong> {{ $timesheet->shift->location }}</p>
                                                    <p><strong>Position:</strong> {{ $timesheet->shift->position }}</p>
                                                    <p><strong>Check-in:</strong> {{ $timesheet->shift->checked_in_at ? \Carbon\Carbon::parse($timesheet->shift->checked_in_at)->format('M d, Y g:i A') : 'N/A' }}</p>
                                                    <p><strong>Check-out:</strong> {{ $timesheet->shift->checked_out_at ? \Carbon\Carbon::parse($timesheet->shift->checked_out_at)->format('M d, Y g:i A') : 'N/A' }}</p>
                                                @else
                                                    <p class="text-muted">No shift attached to this timesheet.</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-12">
                                                <h5 class="border-bottom pb-2 mb-3">Tasks Completed</h5>
                                                <div class="p-3 bg-light rounded">
                                                    {!! nl2br(e($timesheet->tasks_completed)) ?: '<span class="text-muted">No tasks specified</span>' !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-12">
                                                <h5 class="border-bottom pb-2 mb-3">Additional Notes</h5>
                                                <div class="p-3 bg-light rounded">
                                                    {!! nl2br(e($timesheet->notes)) ?: '<span class="text-muted">No additional notes</span>' !!}
                                                </div>
                                            </div>
                                        </div>

                                        @if($timesheet->status == 'rejected' && $timesheet->rejection_reason)
                                            <div class="row mb-4">
                                                <div class="col-12">
                                                    <h5 class="border-bottom pb-2 mb-3 text-danger">Rejection Reason</h5>
                                                    <div class="p-3 bg-light rounded border-start border-danger border-4">
                                                        {!! nl2br(e($timesheet->rejection_reason)) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="d-flex justify-content-between mt-4">
                                            <div>
                                                @if($timesheet->status == 'pending')
                                                    <a href="{{ route('timesheets.edit', $timesheet) }}" class="btn btn-primary">
                                                        <i class="fas fa-edit me-1"></i> Edit Timesheet
                                                    </a>
                                                    <form action="{{ route('timesheets.destroy', $timesheet) }}" method="POST" class="d-inline ms-2" onsubmit="return confirm('Are you sure you want to delete this timesheet?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-trash me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                            <a href="{{ route('timesheets.index') }}" class="btn btn-outline-secondary">
                                                <i class="fas fa-arrow-left me-1"></i> Back to Timesheets
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

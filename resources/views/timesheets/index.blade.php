@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">My Timesheets</h4>
                    <a href="{{ route('timesheets.create') }}" class="btn btn-light">
                        <i class="fas fa-plus-circle me-1"></i> New Timesheet
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Shift</th>
                                    <th>Hours</th>
                                    <th>Status</th>
                                    <th>Submitted</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($timesheets as $timesheet)
                                    <tr>
                                        <td>{{ $timesheet->date->format('M d, Y') }}</td>
                                        <td>
                                            @if($timesheet->shift)
                                                {{ $timesheet->shift->location }} 
                                                <small class="text-muted d-block">
                                                    {{ \Carbon\Carbon::parse($timesheet->start_time)->format('h:i A') }} - 
                                                    {{ \Carbon\Carbon::parse($timesheet->end_time)->format('h:i A') }}
                                                </small>
                                            @else
                                                <span class="text-muted">No shift attached</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($timesheet->hours_worked, 2) }}</td>
                                        <td>
                                            @if($timesheet->status == 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif($timesheet->status == 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @elseif($timesheet->status == 'rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($timesheet->status) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $timesheet->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('timesheets.show', $timesheet) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($timesheet->status == 'pending')
                                                    <a href="{{ route('timesheets.edit', $timesheet) }}" class="btn btn-sm btn-outline-secondary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('timesheets.destroy', $timesheet) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this timesheet?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-clock fa-3x text-muted mb-3"></i>
                                                <h5>No timesheets found</h5>
                                                <p class="text-muted">You haven't submitted any timesheets yet.</p>
                                                <a href="{{ route('timesheets.create') }}" class="btn btn-primary mt-2">
                                                    <i class="fas fa-plus-circle me-1"></i> Create Your First Timesheet
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $timesheets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

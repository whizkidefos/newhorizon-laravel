@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Manage Timesheets</h4>
                    <div>
                        <a href="{{ route('admin.timesheets.export') }}" class="btn btn-light me-2">
                            <i class="fas fa-file-export me-1"></i> Export
                        </a>
                        <a href="{{ route('admin.timesheets.create') }}" class="btn btn-light">
                            <i class="fas fa-plus-circle me-1"></i> Create Timesheet
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <form action="{{ route('admin.timesheets.index') }}" method="GET" class="row g-3">
                            <div class="col-md-3">
                                <label for="user_id" class="form-label">Employee</label>
                                <select class="form-select" id="user_id" name="user_id">
                                    <option value="">All Employees</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">All Statuses</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="date_from" class="form-label">Date From</label>
                                <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                            </div>
                            <div class="col-md-2">
                                <label for="date_to" class="form-label">Date To</label>
                                <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-filter me-1"></i> Filter
                                </button>
                                <a href="{{ route('admin.timesheets.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-undo me-1"></i> Reset
                                </a>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Employee</th>
                                    <th>Date</th>
                                    <th>Hours</th>
                                    <th>Status</th>
                                    <th>Submitted</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($timesheets as $timesheet)
                                    <tr>
                                        <td>#{{ $timesheet->id }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.show', $timesheet->user_id) }}" class="text-decoration-none">
                                                {{ $timesheet->user->name }}
                                            </a>
                                        </td>
                                        <td>{{ $timesheet->date->format('M d, Y') }}</td>
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
                                                <a href="{{ route('admin.timesheets.show', $timesheet) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.timesheets.edit', $timesheet) }}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($timesheet->status == 'pending')
                                                    <form action="{{ route('admin.timesheets.approve', $timesheet) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-success" title="Approve">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $timesheet->id }}" title="Reject">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @endif
                                                <form action="{{ route('admin.timesheets.destroy', $timesheet) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this timesheet?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            
                                            <!-- Reject Modal -->
                                            <div class="modal fade" id="rejectModal{{ $timesheet->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $timesheet->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="{{ route('admin.timesheets.reject', $timesheet) }}" method="POST">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="rejectModalLabel{{ $timesheet->id }}">Reject Timesheet</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="rejection_reason" class="form-label">Reason for Rejection</label>
                                                                    <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required></textarea>
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
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-clock fa-3x text-muted mb-3"></i>
                                                <h5>No timesheets found</h5>
                                                <p class="text-muted">No timesheets match your search criteria.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $timesheets->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

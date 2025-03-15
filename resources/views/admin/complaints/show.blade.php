@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Complaint Details</h4>
                    <div>
                        <a href="{{ route('admin.complaints.index') }}" class="btn btn-light">
                            <i class="fas fa-arrow-left me-1"></i> Back to Complaints
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="d-flex justify-content-between mb-4">
                        <h5 class="mb-0">Complaint #{{ $complaint->id }}</h5>
                        <div>
                            @if($complaint->severity == 'low')
                                <span class="badge bg-info">Low Severity</span>
                            @elseif($complaint->severity == 'medium')
                                <span class="badge bg-warning text-dark">Medium Severity</span>
                            @elseif($complaint->severity == 'high')
                                <span class="badge bg-danger">High Severity</span>
                            @elseif($complaint->severity == 'critical')
                                <span class="badge bg-dark">Critical Severity</span>
                            @endif
                            
                            @if($complaint->status == 'open')
                                <span class="badge bg-secondary ms-1">Open</span>
                            @elseif($complaint->status == 'in_progress')
                                <span class="badge bg-primary ms-1">In Progress</span>
                            @elseif($complaint->status == 'resolved')
                                <span class="badge bg-success ms-1">Resolved</span>
                            @elseif($complaint->status == 'closed')
                                <span class="badge bg-dark ms-1">Closed</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Complaint Information</h5>
                                </div>
                                <div class="card-body">
                                    <h5 class="mb-3">{{ $complaint->title }}</h5>
                                    <div class="d-flex justify-content-between text-muted small mb-3">
                                        <span>Submitted: {{ $complaint->created_at->format('M d, Y g:i A') }}</span>
                                        @if($complaint->created_at != $complaint->updated_at)
                                            <span>Updated: {{ $complaint->updated_at->format('M d, Y g:i A') }}</span>
                                        @endif
                                    </div>
                                    <div class="p-3 bg-light rounded mb-3">
                                        <h6 class="mb-2">Description:</h6>
                                        <div class="text-pre-wrap">
                                            {!! nl2br(e($complaint->description)) !!}
                                        </div>
                                    </div>
                                    
                                    @if($complaint->status == 'resolved' || $complaint->status == 'closed')
                                        <div class="p-3 bg-success bg-opacity-10 rounded border border-success">
                                            <h6 class="mb-2">Resolution Notes:</h6>
                                            <div class="text-pre-wrap">
                                                {!! nl2br(e($complaint->resolution_notes)) ?: '<span class="text-muted">No resolution notes provided.</span>' !!}
                                            </div>
                                            <div class="text-muted small mt-2">
                                                Resolved on: {{ $complaint->resolved_at ? \Carbon\Carbon::parse($complaint->resolved_at)->format('M d, Y g:i A') : 'N/A' }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Employee Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="me-3">
                                            @if($complaint->user->profile_photo_path)
                                                <img src="{{ Storage::url($complaint->user->profile_photo_path) }}" alt="{{ $complaint->user->name }}" class="rounded-circle" width="60" height="60">
                                            @else
                                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                    {{ strtoupper(substr($complaint->user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h5 class="mb-1">{{ $complaint->user->name }}</h5>
                                            <p class="mb-0 text-muted">{{ $complaint->user->email }}</p>
                                        </div>
                                    </div>
                                    <p><strong>Employee ID:</strong> {{ $complaint->user->id }}</p>
                                    <p><strong>Position:</strong> {{ $complaint->user->position ?? 'N/A' }}</p>
                                    <p><strong>Department:</strong> {{ $complaint->user->department ?? 'N/A' }}</p>
                                    <p><strong>Phone:</strong> {{ $complaint->user->phone ?? 'N/A' }}</p>
                                    <a href="{{ route('admin.users.show', $complaint->user) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-user me-1"></i> View Employee Profile
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($complaint->shift)
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Related Shift</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Shift ID:</strong> #{{ $complaint->shift->id }}</p>
                                        <p><strong>Date:</strong> {{ $complaint->shift->date->format('M d, Y') }}</p>
                                        <p><strong>Location:</strong> {{ $complaint->shift->location }}</p>
                                        <p><strong>Position:</strong> {{ $complaint->shift->position }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Check-in:</strong> {{ $complaint->shift->checked_in_at ? \Carbon\Carbon::parse($complaint->shift->checked_in_at)->format('M d, Y g:i A') : 'N/A' }}</p>
                                        <p><strong>Check-out:</strong> {{ $complaint->shift->checked_out_at ? \Carbon\Carbon::parse($complaint->shift->checked_out_at)->format('M d, Y g:i A') : 'N/A' }}</p>
                                        <p><strong>Status:</strong> {{ ucfirst($complaint->shift->status) }}</p>
                                        <a href="{{ route('admin.shifts.show', $complaint->shift) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-calendar-alt me-1"></i> View Shift Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            <a href="{{ route('admin.complaints.edit', $complaint) }}" class="btn btn-primary me-2">
                                <i class="fas fa-edit me-1"></i> Edit Complaint
                            </a>
                            @if($complaint->status == 'open')
                                <form action="{{ route('admin.complaints.in-progress', $complaint) }}" method="POST" class="d-inline me-2">
                                    @csrf
                                    <button type="submit" class="btn btn-info">
                                        <i class="fas fa-hourglass-half me-1"></i> Mark as In Progress
                                    </button>
                                </form>
                            @endif
                            @if($complaint->status == 'open' || $complaint->status == 'in_progress')
                                <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#resolveModal">
                                    <i class="fas fa-check me-1"></i> Resolve
                                </button>
                            @endif
                            @if($complaint->status == 'resolved')
                                <form action="{{ route('admin.complaints.close', $complaint) }}" method="POST" class="d-inline me-2">
                                    @csrf
                                    <button type="submit" class="btn btn-dark">
                                        <i class="fas fa-archive me-1"></i> Close
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('admin.complaints.destroy', $complaint) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this complaint?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-trash me-1"></i> Delete
                                </button>
                            </form>
                        </div>
                        <a href="{{ route('admin.complaints.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Complaints
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Resolve Modal -->
<div class="modal fade" id="resolveModal" tabindex="-1" aria-labelledby="resolveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.complaints.resolve', $complaint) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="resolveModalLabel">Resolve Complaint</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="resolution_notes" class="form-label">Resolution Notes</label>
                        <textarea class="form-control" id="resolution_notes" name="resolution_notes" rows="4" required></textarea>
                        <div class="form-text">Please provide details about how this complaint was resolved. This will be visible to the employee.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Resolve Complaint</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Complaint Details</h4>
                    <a href="{{ route('complaints.index') }}" class="btn btn-dark">
                        <i class="fas fa-arrow-left me-1"></i> Back to Complaints
                    </a>
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
                            @if($complaint->status == 'open')
                                <span class="badge bg-secondary">Open</span>
                            @elseif($complaint->status == 'in_progress')
                                <span class="badge bg-primary">In Progress</span>
                            @elseif($complaint->status == 'resolved')
                                <span class="badge bg-success">Resolved</span>
                            @elseif($complaint->status == 'closed')
                                <span class="badge bg-dark">Closed</span>
                            @endif
                            
                            @if($complaint->severity == 'low')
                                <span class="badge bg-info ms-1">Low Severity</span>
                            @elseif($complaint->severity == 'medium')
                                <span class="badge bg-warning text-dark ms-1">Medium Severity</span>
                            @elseif($complaint->severity == 'high')
                                <span class="badge bg-danger ms-1">High Severity</span>
                            @elseif($complaint->severity == 'critical')
                                <span class="badge bg-dark ms-1">Critical Severity</span>
                            @endif
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">{{ $complaint->title }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <div class="d-flex justify-content-between text-muted small mb-2">
                                    <span>Submitted: {{ $complaint->created_at->format('M d, Y g:i A') }}</span>
                                    @if($complaint->created_at != $complaint->updated_at)
                                        <span>Updated: {{ $complaint->updated_at->format('M d, Y g:i A') }}</span>
                                    @endif
                                </div>
                                <div class="p-3 bg-light rounded">
                                    {!! nl2br(e($complaint->description)) !!}
                                </div>
                            </div>

                            @if($complaint->shift)
                                <div class="mt-4">
                                    <h6 class="border-bottom pb-2 mb-3">Related Shift</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>Date:</strong> {{ $complaint->shift->date->format('M d, Y') }}</p>
                                            <p class="mb-1"><strong>Location:</strong> {{ $complaint->shift->location }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>Check-in:</strong> {{ $complaint->shift->checked_in_at ? \Carbon\Carbon::parse($complaint->shift->checked_in_at)->format('g:i A') : 'N/A' }}</p>
                                            <p class="mb-1"><strong>Check-out:</strong> {{ $complaint->shift->checked_out_at ? \Carbon\Carbon::parse($complaint->shift->checked_out_at)->format('g:i A') : 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($complaint->status == 'resolved' || $complaint->status == 'closed')
                        <div class="card mb-4 border-success">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">Resolution</h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted small mb-2">Resolved on: {{ $complaint->resolved_at ? \Carbon\Carbon::parse($complaint->resolved_at)->format('M d, Y g:i A') : 'N/A' }}</p>
                                <div class="p-3 bg-light rounded">
                                    {!! nl2br(e($complaint->resolution_notes)) ?: '<span class="text-muted">No resolution notes provided.</span>' !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            @if($complaint->status == 'open')
                                <a href="{{ route('complaints.edit', $complaint) }}" class="btn btn-primary">
                                    <i class="fas fa-edit me-1"></i> Edit Complaint
                                </a>
                                <form action="{{ route('complaints.destroy', $complaint) }}" method="POST" class="d-inline ms-2" onsubmit="return confirm('Are you sure you want to delete this complaint?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                        <a href="{{ route('complaints.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Complaints
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

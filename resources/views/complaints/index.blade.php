@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">My Complaints</h4>
                    <a href="{{ route('complaints.create') }}" class="btn btn-dark">
                        <i class="fas fa-plus-circle me-1"></i> New Complaint
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
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Severity</th>
                                    <th>Status</th>
                                    <th>Submitted</th>
                                    <th>Last Updated</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($complaints as $complaint)
                                    <tr>
                                        <td>#{{ $complaint->id }}</td>
                                        <td>
                                            <a href="{{ route('complaints.show', $complaint) }}" class="text-decoration-none">
                                                {{ $complaint->title }}
                                            </a>
                                            @if($complaint->shift)
                                                <small class="text-muted d-block">
                                                    Related to shift on {{ $complaint->shift->date->format('M d, Y') }}
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($complaint->severity == 'low')
                                                <span class="badge bg-info">Low</span>
                                            @elseif($complaint->severity == 'medium')
                                                <span class="badge bg-warning text-dark">Medium</span>
                                            @elseif($complaint->severity == 'high')
                                                <span class="badge bg-danger">High</span>
                                            @elseif($complaint->severity == 'critical')
                                                <span class="badge bg-dark">Critical</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($complaint->status == 'open')
                                                <span class="badge bg-secondary">Open</span>
                                            @elseif($complaint->status == 'in_progress')
                                                <span class="badge bg-primary">In Progress</span>
                                            @elseif($complaint->status == 'resolved')
                                                <span class="badge bg-success">Resolved</span>
                                            @elseif($complaint->status == 'closed')
                                                <span class="badge bg-dark">Closed</span>
                                            @endif
                                        </td>
                                        <td>{{ $complaint->created_at->format('M d, Y') }}</td>
                                        <td>{{ $complaint->updated_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('complaints.show', $complaint) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($complaint->status == 'open')
                                                    <a href="{{ route('complaints.edit', $complaint) }}" class="btn btn-sm btn-outline-secondary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('complaints.destroy', $complaint) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this complaint?');">
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
                                        <td colspan="7" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-clipboard-check fa-3x text-muted mb-3"></i>
                                                <h5>No complaints found</h5>
                                                <p class="text-muted">You haven't submitted any complaints yet.</p>
                                                <a href="{{ route('complaints.create') }}" class="btn btn-warning mt-2">
                                                    <i class="fas fa-plus-circle me-1"></i> Submit a Complaint
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $complaints->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

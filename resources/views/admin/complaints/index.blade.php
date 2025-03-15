@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Manage Complaints</h4>
                    <div>
                        <a href="{{ route('admin.complaints.export') }}" class="btn btn-light">
                            <i class="fas fa-file-export me-1"></i> Export
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
                        <form action="{{ route('admin.complaints.index') }}" method="GET" class="row g-3">
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
                                    <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="severity" class="form-label">Severity</label>
                                <select class="form-select" id="severity" name="severity">
                                    <option value="">All Severities</option>
                                    <option value="low" {{ request('severity') == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ request('severity') == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ request('severity') == 'high' ? 'selected' : '' }}>High</option>
                                    <option value="critical" {{ request('severity') == 'critical' ? 'selected' : '' }}>Critical</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="date_from" class="form-label">Date From</label>
                                <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-filter me-1"></i> Filter
                                </button>
                                <a href="{{ route('admin.complaints.index') }}" class="btn btn-outline-secondary">
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
                                    <th>Title</th>
                                    <th>Severity</th>
                                    <th>Status</th>
                                    <th>Submitted</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($complaints as $complaint)
                                    <tr>
                                        <td>#{{ $complaint->id }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.show', $complaint->user_id) }}" class="text-decoration-none">
                                                {{ $complaint->user->name }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.complaints.show', $complaint) }}" class="text-decoration-none">
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
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.complaints.show', $complaint) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.complaints.edit', $complaint) }}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($complaint->status == 'open')
                                                    <form action="{{ route('admin.complaints.in-progress', $complaint) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-primary" title="Mark as In Progress">
                                                            <i class="fas fa-hourglass-half"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                @if($complaint->status == 'open' || $complaint->status == 'in_progress')
                                                    <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#resolveModal{{ $complaint->id }}" title="Resolve">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                @endif
                                                <form action="{{ route('admin.complaints.destroy', $complaint) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this complaint?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            
                                            <!-- Resolve Modal -->
                                            <div class="modal fade" id="resolveModal{{ $complaint->id }}" tabindex="-1" aria-labelledby="resolveModalLabel{{ $complaint->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="{{ route('admin.complaints.resolve', $complaint) }}" method="POST">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="resolveModalLabel{{ $complaint->id }}">Resolve Complaint</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="resolution_notes" class="form-label">Resolution Notes</label>
                                                                    <textarea class="form-control" id="resolution_notes" name="resolution_notes" rows="3" required></textarea>
                                                                    <div class="form-text">Please provide details about how this complaint was resolved.</div>
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
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="fas fa-clipboard-check fa-3x text-muted mb-3"></i>
                                                <h5>No complaints found</h5>
                                                <p class="text-muted">No complaints match your search criteria.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $complaints->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

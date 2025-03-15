@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Edit Complaint</h4>
                    <div>
                        <a href="{{ route('admin.complaints.show', $complaint) }}" class="btn btn-light">
                            <i class="fas fa-arrow-left me-1"></i> Back to Complaint
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.complaints.update', $complaint) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="user_id" class="form-label">Employee</label>
                                <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                    <option value="">Select Employee</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id', $complaint->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="shift_id" class="form-label">Related Shift (Optional)</label>
                                <select class="form-select @error('shift_id') is-invalid @enderror" id="shift_id" name="shift_id">
                                    <option value="">No related shift</option>
                                    @foreach($shifts as $shift)
                                        <option value="{{ $shift->id }}" {{ old('shift_id', $complaint->shift_id) == $shift->id ? 'selected' : '' }}>
                                            {{ $shift->date->format('M d, Y') }} - {{ $shift->location }} ({{ $shift->user->name }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('shift_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="title" class="form-label">Complaint Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $complaint->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="open" {{ old('status', $complaint->status) == 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="in_progress" {{ old('status', $complaint->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="resolved" {{ old('status', $complaint->status) == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    <option value="closed" {{ old('status', $complaint->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="severity" class="form-label">Severity Level</label>
                            <select class="form-select @error('severity') is-invalid @enderror" id="severity" name="severity" required>
                                <option value="low" {{ old('severity', $complaint->severity) == 'low' ? 'selected' : '' }}>Low - Minor issue, no immediate action required</option>
                                <option value="medium" {{ old('severity', $complaint->severity) == 'medium' ? 'selected' : '' }}>Medium - Needs attention but not urgent</option>
                                <option value="high" {{ old('severity', $complaint->severity) == 'high' ? 'selected' : '' }}>High - Requires prompt attention</option>
                                <option value="critical" {{ old('severity', $complaint->severity) == 'critical' ? 'selected' : '' }}>Critical - Immediate action required</option>
                            </select>
                            @error('severity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description', $complaint->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div id="resolution-container" class="mb-3" style="{{ old('status', $complaint->status) == 'resolved' || old('status', $complaint->status) == 'closed' ? '' : 'display: none;' }}">
                            <label for="resolution_notes" class="form-label">Resolution Notes</label>
                            <textarea class="form-control @error('resolution_notes') is-invalid @enderror" id="resolution_notes" name="resolution_notes" rows="4">{{ old('resolution_notes', $complaint->resolution_notes) }}</textarea>
                            <div class="form-text">Please provide details about how this complaint was resolved. This will be visible to the employee.</div>
                            @error('resolution_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <div class="mt-3">
                                <label for="resolved_at" class="form-label">Resolution Date</label>
                                <input type="datetime-local" class="form-control @error('resolved_at') is-invalid @enderror" id="resolved_at" name="resolved_at" value="{{ old('resolved_at', $complaint->resolved_at ? \Carbon\Carbon::parse($complaint->resolved_at)->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}">
                                @error('resolved_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.complaints.show', $complaint) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Complaint
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show/hide resolution fields based on status
        const statusSelect = document.getElementById('status');
        const resolutionContainer = document.getElementById('resolution-container');
        const resolutionNotesField = document.getElementById('resolution_notes');
        
        statusSelect.addEventListener('change', function() {
            if (this.value === 'resolved' || this.value === 'closed') {
                resolutionContainer.style.display = '';
                resolutionNotesField.setAttribute('required', 'required');
            } else {
                resolutionContainer.style.display = 'none';
                resolutionNotesField.removeAttribute('required');
            }
        });
    });
</script>
@endpush
@endsection

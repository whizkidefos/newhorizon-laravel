@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Edit Complaint</h4>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('complaints.update', $complaint) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Complaint Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $complaint->title) }}" required placeholder="Brief summary of the issue">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="severity" class="form-label">Severity Level</label>
                            <select class="form-select @error('severity') is-invalid @enderror" id="severity" name="severity" required>
                                <option value="" disabled>Select severity level</option>
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
                            <label for="shift_id" class="form-label">Related Shift (Optional)</label>
                            <select class="form-select @error('shift_id') is-invalid @enderror" id="shift_id" name="shift_id">
                                <option value="">No related shift</option>
                                @foreach(auth()->user()->shifts()->whereIn('status', ['completed'])->orderBy('date', 'desc')->get() as $shift)
                                    <option value="{{ $shift->id }}" {{ old('shift_id', $complaint->shift_id) == $shift->id ? 'selected' : '' }}>
                                        {{ $shift->date->format('M d, Y') }} - {{ $shift->location }}
                                    </option>
                                @endforeach
                            </select>
                            @error('shift_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="6" required placeholder="Please provide detailed information about the issue, including what happened, when it occurred, who was involved, and any other relevant details.">{{ old('description', $complaint->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('complaints.show', $complaint) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-1"></i> Update Complaint
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

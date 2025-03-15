@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Submit a Complaint for Your Shift</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-4">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas fa-info-circle fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="alert-heading">Shift Information</h5>
                                <p class="mb-0"><strong>Date:</strong> {{ $shift->date }}</p>
                                <p class="mb-0"><strong>Location:</strong> {{ $shift->location }}</p>
                                <p class="mb-0"><strong>Time:</strong> {{ \Carbon\Carbon::parse($shift->checked_in_at)->format('h:i A') }} - {{ \Carbon\Carbon::parse($shift->checked_out_at)->format('h:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('complaints.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="shift_id" value="{{ $shift->id }}">
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Complaint Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required placeholder="Brief summary of the issue">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="severity" class="form-label">Severity Level</label>
                            <select class="form-select @error('severity') is-invalid @enderror" id="severity" name="severity" required>
                                <option value="" disabled selected>Select severity level</option>
                                <option value="low" {{ old('severity') == 'low' ? 'selected' : '' }}>Low - Minor issue, no immediate action required</option>
                                <option value="medium" {{ old('severity') == 'medium' ? 'selected' : '' }}>Medium - Needs attention but not urgent</option>
                                <option value="high" {{ old('severity') == 'high' ? 'selected' : '' }}>High - Requires prompt attention</option>
                                <option value="critical" {{ old('severity') == 'critical' ? 'selected' : '' }}>Critical - Immediate action required</option>
                            </select>
                            @error('severity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="6" required placeholder="Please provide detailed information about the issue, including what happened, when it occurred, who was involved, and any other relevant details.">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('shifts.checkout-options', $shift) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-paper-plane me-1"></i> Submit Complaint
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Guidelines for Submitting a Complaint</h5>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li><strong>Be specific</strong> - Include details about what happened, when, where, and who was involved.</li>
                        <li><strong>Be factual</strong> - Stick to the facts and avoid emotional language.</li>
                        <li><strong>Be constructive</strong> - If possible, suggest solutions or improvements.</li>
                        <li><strong>Be professional</strong> - Maintain a professional tone throughout your complaint.</li>
                        <li><strong>Be timely</strong> - Submit your complaint as soon as possible after the incident.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

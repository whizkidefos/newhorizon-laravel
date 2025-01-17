{{-- resources/views/shifts/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Shift details here --}}
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if ("geolocation" in navigator) {
            navigator.geolocation.watchPosition(function(position) {
                axios.post('{{ route("shifts.update-location", $shift) }}', {
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude
                })
                .then(response => {
                    console.log('Location updated successfully');
                })
                .catch(error => {
                    console.error('Error updating location:', error);
                });
            }, function(error) {
                console.error('Error getting location:', error);
            }, {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0
            });
        }
    });
</script>
@endpush
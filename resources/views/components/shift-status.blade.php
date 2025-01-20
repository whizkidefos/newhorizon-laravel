@props(['status'])

@php
$classes = match($status) {
    'open' => 'bg-yellow-100 text-yellow-800',
    'assigned' => 'bg-blue-100 text-blue-800',
    'checked_in' => 'bg-green-100 text-green-800',
    'completed' => 'bg-gray-100 text-gray-800',
    'cancelled' => 'bg-red-100 text-red-800',
    default => 'bg-gray-100 text-gray-800'
};
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $classes }}">
    {{ ucfirst($status) }}
</span>
@props(['user'])

@php
    $initials = collect(explode(' ', $user->name))
        ->map(function($segment) {
            return strtoupper(substr($segment, 0, 1));
        })
        ->take(2)
        ->join('');
@endphp

<div {{ $attributes->merge(['class' => 'inline-flex items-center justify-center h-8 w-8 rounded-full bg-blue-600 text-white text-sm font-semibold']) }}>
    {{ $initials }}
</div>

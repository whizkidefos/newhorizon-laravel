@props(['user', 'size' => 'md'])

@php
    $initials = collect(explode(' ', $user->first_name . ' ' . $user->last_name))
        ->map(function($segment) {
            return strtoupper(substr($segment, 0, 1));
        })
        ->take(2)
        ->join('');

    $sizes = [
        'sm' => 'h-8 w-8 text-sm',
        'md' => 'h-10 w-10 text-base',
        'lg' => 'h-12 w-12 text-lg'
    ];

    $sizeClasses = $sizes[$size] ?? $sizes['md'];
@endphp

<div {{ $attributes->merge(['class' => 'relative inline-flex items-center justify-center ' . $sizeClasses . ' rounded-full bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-medium transition-colors duration-200']) }}
     title="{{ $user->first_name }} {{ $user->last_name }}">
    @if($user->profile_photo)
        <img src="{{ Storage::url($user->profile_photo) }}" 
             alt="{{ $user->first_name }} {{ $user->last_name }}"
             class="absolute inset-0 w-full h-full object-cover rounded-full">
    @else
        <span class="select-none">{{ $initials }}</span>
    @endif
</div>

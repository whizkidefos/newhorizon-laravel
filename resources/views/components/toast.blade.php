@props(['type' => 'success', 'message'])

@php
    $classes = match($type) {
        'success' => 'bg-green-50 text-green-800 dark:bg-green-900/20 dark:text-green-400',
        'error' => 'bg-red-50 text-red-800 dark:bg-red-900/20 dark:text-red-400',
        'warning' => 'bg-yellow-50 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400',
        'info' => 'bg-blue-50 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400',
        default => 'bg-green-50 text-green-800 dark:bg-green-900/20 dark:text-green-400',
    };
    
    $iconClasses = match($type) {
        'success' => 'text-green-400 dark:text-green-300',
        'error' => 'text-red-400 dark:text-red-300',
        'warning' => 'text-yellow-400 dark:text-yellow-300',
        'info' => 'text-blue-400 dark:text-blue-300',
        default => 'text-green-400 dark:text-green-300',
    };
@endphp

<div 
    x-data="{ show: true }"
    x-show="show"
    x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    x-init="setTimeout(() => show = false, 5000)"
    class="fixed top-4 right-4 z-50 max-w-sm w-full shadow-lg rounded-lg pointer-events-auto {{ $classes }}"
>
    <div class="p-4">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                @if($type === 'success')
                    <svg class="h-6 w-6 {{ $iconClasses }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                @elseif($type === 'error')
                    <svg class="h-6 w-6 {{ $iconClasses }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                @elseif($type === 'warning')
                    <svg class="h-6 w-6 {{ $iconClasses }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                @elseif($type === 'info')
                    <svg class="h-6 w-6 {{ $iconClasses }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                @endif
            </div>
            <div class="ml-3 w-0 flex-1 pt-0.5">
                <p class="text-sm font-medium">{{ $message }}</p>
            </div>
            <div class="ml-4 flex-shrink-0 flex">
                <button 
                    @click="show = false" 
                    class="inline-flex text-gray-400 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150"
                >
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

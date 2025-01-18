@props([
    'title',
    'description',
    'icon' => null
])

<div class="relative bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
    @if($icon)
        <div class="absolute top-0 right-0 -mt-6 mr-6 w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center">
            <x-dynamic-component :component="'icons.' . $icon" class="w-6 h-6 text-white" />
        </div>
    @endif
    
    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
        {{ $title }}
    </h3>
    
    <p class="text-gray-600 dark:text-gray-400 mb-4">
        {{ $description }}
    </p>

    @if(isset($slot) && !empty(trim($slot)))
        <div class="mt-4">
            {{ $slot }}
        </div>
    @endif
</div>
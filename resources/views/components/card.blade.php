<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg hover:shadow-lg transition-shadow duration-300 ease-in-out">
    @if(isset($image))
        <div class="aspect-w-16 aspect-h-9">
            {{ $image }}
        </div>
    @endif
    
    <div class="p-6">
        @if(isset($title))
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                {{ $title }}
            </h3>
        @endif
        
        @if(isset($subtitle))
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                {{ $subtitle }}
            </p>
        @endif
        
        <div class="text-gray-700 dark:text-gray-300">
            {{ $slot }}
        </div>
        
        @if(isset($footer))
            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>
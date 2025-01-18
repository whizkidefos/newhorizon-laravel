@props(['items'])

<div class="relative">
    <!-- Line down the middle -->
    <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-0.5 bg-blue-200 dark:bg-blue-800"></div>
    
    <div class="space-y-12">
        @foreach($items as $item)
            <div class="relative">
                <!-- Dot -->
                <div class="absolute left-1/2 transform -translate-x-1/2 -translate-y-4 w-4 h-4 rounded-full bg-blue-500"></div>
                
                <div class="relative flex justify-between items-center">
                    <div class="w-5/12 {{ $loop->even ? 'order-2 text-left pl-8' : 'text-right pr-8' }}">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $item['title'] }}</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $item['description'] }}</p>
                    </div>
                    <div class="w-5/12 {{ $loop->even ? 'order-1 text-right pr-8' : 'text-left pl-8' }}">
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $item['date'] }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
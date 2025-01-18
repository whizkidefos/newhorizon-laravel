<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg hover-scale p-6"
     x-data="{ count: 0, target: {{ $value }}, duration: 2000 }"
     x-init="() => {
         const start = performance.now();
         const animate = (currentTime) => {
             const elapsed = currentTime - start;
             const progress = Math.min(elapsed / duration, 1);
             
             count = Math.floor(target * progress);
             
             if (progress < 1) {
                 requestAnimationFrame(animate);
             }
         };
         requestAnimationFrame(animate);
     }">
    <div class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
        {{ $title }}
    </div>
    <div class="mt-2 text-3xl font-semibold text-gray-900 dark:text-white">
        <span x-text="count"></span>{{ isset($suffix) ? '+' : '' }}
    </div>
    @if(isset($subtitle))
        <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            {{ $subtitle }}
        </div>
    @endif
</div>
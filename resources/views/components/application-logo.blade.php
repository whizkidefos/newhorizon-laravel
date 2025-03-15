<div {{ $attributes->merge(['class' => 'flex items-center']) }}>
    <svg class="h-10 w-auto" viewBox="0 0 400 120" fill="none" xmlns="http://www.w3.org/2000/svg">
        <!-- Sun rays -->
        <g class="dark:text-yellow-400 text-yellow-500">
            <!-- Center sun circle -->
            <circle cx="100" cy="60" r="30" fill="currentColor"/>
            
            <!-- Sun rays -->
            <path d="M100 15 L100 30" stroke="currentColor" stroke-width="6" stroke-linecap="round"/>
            <path d="M100 90 L100 105" stroke="currentColor" stroke-width="6" stroke-linecap="round"/>
            <path d="M55 60 L70 60" stroke="currentColor" stroke-width="6" stroke-linecap="round"/>
            <path d="M130 60 L145 60" stroke="currentColor" stroke-width="6" stroke-linecap="round"/>
            
            <!-- Diagonal rays -->
            <path d="M70 30 L80 40" stroke="currentColor" stroke-width="6" stroke-linecap="round"/>
            <path d="M70 90 L80 80" stroke="currentColor" stroke-width="6" stroke-linecap="round"/>
            <path d="M130 30 L120 40" stroke="currentColor" stroke-width="6" stroke-linecap="round"/>
            <path d="M130 90 L120 80" stroke="currentColor" stroke-width="6" stroke-linecap="round"/>
        </g>
        
        <!-- Horizon curve -->
        <path d="M40 80 Q100 110 160 80" stroke-width="8" stroke="currentColor" class="dark:text-blue-400 text-blue-500" fill="none"/>
        
        <!-- Text part -->
        <g class="dark:text-gray-100 text-gray-900">
            <text x="180" y="55" font-family="Arial, sans-serif" font-weight="900" font-size="24" fill="currentColor">
                NEW HORIZON
            </text>
            <text x="180" y="85" font-family="Arial, sans-serif" font-weight="600" font-size="14" fill="currentColor">
                HEALTHCARE SERVICES
            </text>
        </g>
    </svg>
</div>
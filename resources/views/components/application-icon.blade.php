<svg {{ $attributes }} viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
  <!-- Sun rays -->
  <g class="dark:text-yellow-400 text-yellow-500">
    <!-- Center sun circle -->
    <circle cx="50" cy="50" r="25" fill="currentColor"/>
    
    <!-- Sun rays -->
    <path d="M50 15 L50 25" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
    <path d="M50 75 L50 85" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
    <path d="M15 50 L25 50" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
    <path d="M75 50 L85 50" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
    
    <!-- Diagonal rays -->
    <path d="M25 25 L32 32" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
    <path d="M25 75 L32 68" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
    <path d="M75 25 L68 32" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
    <path d="M75 75 L68 68" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
  </g>
  
  <!-- Horizon curve -->
  <path d="M15 70 Q50 95 85 70" stroke-width="5" stroke="currentColor" class="dark:text-blue-400 text-blue-500" fill="none"/>
</svg>
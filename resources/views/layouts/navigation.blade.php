<nav x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
     x-init="$watch('darkMode', val => {
         localStorage.setItem('darkMode', val)
         document.documentElement.classList.toggle('dark', val)
     })">
    <!-- Other navigation items -->
    
    <button @click="darkMode = !darkMode" 
            class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
        <template x-if="darkMode">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <!-- Sun icon -->
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </template>
        <template x-if="!darkMode">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <!-- Moon icon -->
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
        </template>
    </button>
</nav>
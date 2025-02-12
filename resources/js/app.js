import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Initialize dark mode
const initDarkMode = () => {
    const isDarkMode = localStorage.getItem('darkMode') === 'true' || 
        (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
    
    if (isDarkMode) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
};

// Initialize dark mode on page load
initDarkMode();

// Watch for system color scheme changes
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
    if (!('darkMode' in localStorage)) {
        if (event.matches) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
});

Alpine.start();

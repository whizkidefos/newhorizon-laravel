<nav x-data="{ open: false, darkMode: localStorage.getItem('darkMode') === 'true' }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @guest
                        <!-- Links for non-authenticated users -->
                        <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                            {{ __('Home') }}
                        </x-nav-link>
                        <x-nav-link :href="route('about')" :active="request()->routeIs('about')">
                            {{ __('About Us') }}
                        </x-nav-link>
                        <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                            {{ __('Contact') }}
                        </x-nav-link>
                    @else
                        <!-- Links for authenticated users -->
                        @if(auth()->user()->hasRole(['super-admin', 'admin']))
                            <!-- Admin Links -->
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                        @else
                            <!-- Regular User Links -->
                            <x-nav-link :href="route('profile.index')" :active="request()->routeIs('profile.*')">
                                {{ __('Profile') }}
                            </x-nav-link>
                        @endif

                        <!-- Common Links for All Authenticated Users -->
                        <x-nav-link :href="route('courses.index')" :active="request()->routeIs('courses.*')">
                            {{ __('Courses') }}
                        </x-nav-link>
                        
                        <!-- Shifts Management -->
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ __('Shifts') }}</div>
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('shifts.index')">
                                    {{ __('Available Shifts') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('shifts.my-shifts')">
                                    {{ __('My Shifts') }}
                                </x-dropdown-link>
                                @if(auth()->user()->hasRole(['super-admin', 'admin']))
                                    <x-dropdown-link :href="route('admin.shifts.index')">
                                        {{ __('Manage Shifts') }}
                                    </x-dropdown-link>
                                @endif
                            </x-slot>
                        </x-dropdown>
                        
                        <!-- Timesheets Management -->
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ __('Timesheets') }}</div>
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('timesheets.index')">
                                    {{ __('My Timesheets') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('timesheets.create')">
                                    {{ __('Submit Timesheet') }}
                                </x-dropdown-link>
                                @if(auth()->user()->hasRole(['super-admin', 'admin']))
                                    <x-dropdown-link :href="route('admin.timesheets.index')">
                                        {{ __('Manage Timesheets') }}
                                    </x-dropdown-link>
                                @endif
                            </x-slot>
                        </x-dropdown>
                        
                        <!-- Complaints -->
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ __('Complaints') }}</div>
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('complaints.index')">
                                    {{ __('My Complaints') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('complaints.create')">
                                    {{ __('Submit Complaint') }}
                                </x-dropdown-link>
                                @if(auth()->user()->hasRole(['super-admin', 'admin']))
                                    <x-dropdown-link :href="route('admin.complaints.index')">
                                        {{ __('Manage Complaints') }}
                                    </x-dropdown-link>
                                @endif
                            </x-slot>
                        </x-dropdown>
                    @endguest
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-3">
                <!-- Dark Mode Toggle -->
                <button 
                    @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode.toString()); document.documentElement.classList.toggle('dark')" 
                    class="p-2 rounded-md text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none"
                >
                    <svg x-show="!darkMode" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg x-show="darkMode" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>

                <!-- Settings Dropdown -->
                @guest
                    <div class="flex space-x-2">
                        <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Login') }}
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:bg-gray-300 dark:focus:bg-gray-600 active:bg-gray-400 dark:active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Register') }}
                        </a>
                    </div>
                @else
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div class="flex items-center">
                                    @if(Auth::user()->profile_photo)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="{{ Auth::user()->first_name }}" class="h-8 w-8 rounded-full object-cover mr-2">
                                    @else
                                        <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white mr-2">
                                            {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <span>{{ Auth::user()->first_name }}</span>
                                </div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.index')">
                                {{ __('My Profile') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Edit Profile') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('profile.bank-details')">
                                {{ __('Bank Details') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('profile.work-history')">
                                {{ __('Work History') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('profile.trainings')">
                                {{ __('Trainings') }}
                            </x-dropdown-link>
                            
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endguest
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <!-- Dark Mode Toggle (Mobile) -->
                <button 
                    @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode.toString()); document.documentElement.classList.toggle('dark')" 
                    class="p-2 rounded-md text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none"
                >
                    <svg x-show="!darkMode" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg x-show="darkMode" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>
                
                <!-- Mobile Menu Button -->
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @guest
                <!-- Mobile Links for non-authenticated users -->
                <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                    {{ __('Home') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('about')" :active="request()->routeIs('about')">
                    {{ __('About Us') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                    {{ __('Contact') }}
                </x-responsive-nav-link>
                <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                    <div class="flex items-center justify-center space-x-2 px-4">
                        <a href="{{ route('login') }}" class="w-full text-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Login') }}
                        </a>
                        <a href="{{ route('register') }}" class="w-full text-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:bg-gray-300 dark:focus:bg-gray-600 active:bg-gray-400 dark:active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Register') }}
                        </a>
                    </div>
                </div>
            @else
                <!-- Mobile Links for authenticated users -->
                @if(auth()->user()->hasRole(['super-admin', 'admin']))
                    <!-- Admin Links -->
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                @else
                    <!-- Regular User Links -->
                    <x-responsive-nav-link :href="route('profile.index')" :active="request()->routeIs('profile.*')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Common Links for All Authenticated Users -->
                <x-responsive-nav-link :href="route('courses.index')" :active="request()->routeIs('courses.*')">
                    {{ __('Courses') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('shifts.index')" :active="request()->routeIs('shifts.index')">
                    {{ __('Available Shifts') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('shifts.my-shifts')" :active="request()->routeIs('shifts.my-shifts')">
                    {{ __('My Shifts') }}
                </x-responsive-nav-link>

                @if(auth()->user()->hasRole(['super-admin', 'admin']))
                    <x-responsive-nav-link :href="route('admin.shifts.index')" :active="request()->routeIs('admin.shifts.index')">
                        {{ __('Manage Shifts') }}
                    </x-responsive-nav-link>
                @endif

                <x-responsive-nav-link :href="route('timesheets.index')" :active="request()->routeIs('timesheets.index')">
                    {{ __('My Timesheets') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('timesheets.create')" :active="request()->routeIs('timesheets.create')">
                    {{ __('Submit Timesheet') }}
                </x-responsive-nav-link>

                @if(auth()->user()->hasRole(['super-admin', 'admin']))
                    <x-responsive-nav-link :href="route('admin.timesheets.index')" :active="request()->routeIs('admin.timesheets.index')">
                        {{ __('Manage Timesheets') }}
                    </x-responsive-nav-link>
                @endif

                <x-responsive-nav-link :href="route('complaints.index')" :active="request()->routeIs('complaints.index')">
                    {{ __('My Complaints') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('complaints.create')" :active="request()->routeIs('complaints.create')">
                    {{ __('Submit Complaint') }}
                </x-responsive-nav-link>

                @if(auth()->user()->hasRole(['super-admin', 'admin']))
                    <x-responsive-nav-link :href="route('admin.complaints.index')" :active="request()->routeIs('admin.complaints.index')">
                        {{ __('Manage Complaints') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                    <div class="flex items-center px-4">
                        @if(Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="{{ Auth::user()->first_name }}" class="h-10 w-10 rounded-full object-cover mr-3">
                        @else
                            <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white mr-3">
                                {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <x-responsive-nav-link :href="route('profile.index')">
                            {{ __('My Profile') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('profile.edit')">
                            {{ __('Edit Profile') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('profile.bank-details')">
                            {{ __('Bank Details') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('profile.work-history')">
                            {{ __('Work History') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('profile.trainings')">
                            {{ __('Trainings') }}
                        </x-responsive-nav-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-responsive-nav-link>
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </div>
</nav>

<!-- Initialize Dark Mode -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const darkMode = localStorage.getItem('darkMode') === 'true';
        if (darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    });
</script>
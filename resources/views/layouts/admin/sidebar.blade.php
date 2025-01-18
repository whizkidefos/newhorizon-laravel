<aside class="w-64 bg-white dark:bg-gray-800 min-h-screen">
    <div class="px-4 py-5 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-lg font-medium text-gray-900 dark:text-white">
            Admin Dashboard
        </h2>
    </div>
    
    <nav class="mt-5 px-2">
        <a href="{{ route('admin.dashboard') }}" 
           class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
            <svg class="mr-4 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <!-- Dashboard icon -->
            </svg>
            Dashboard
        </a>

        <a href="{{ route('admin.users.index') }}"
           class="mt-1 group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.users.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
            Users
        </a>

        <a href="{{ route('admin.shifts.index') }}"
           class="mt-1 group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.shifts.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
            Shifts
        </a>

        <a href="{{ route('admin.courses.index') }}"
           class="mt-1 group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.courses.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
            Courses
        </a>

        <a href="{{ route('admin.reports.index') }}"
           class="mt-1 group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.reports.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
            Reports
        </a>
    </nav>
</aside>
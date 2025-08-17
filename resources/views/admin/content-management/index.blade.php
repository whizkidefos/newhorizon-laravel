<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Content Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">{{ __('Content Management Dashboard') }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Logo Management Card -->
                        <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-6">
                            <div class="flex items-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <h4 class="text-lg font-medium">{{ __('Logo Management') }}</h4>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                {{ __('Update your site logo and alt text.') }}
                            </p>
                            <a href="{{ route('admin.content.logo') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Manage Logo') }}
                            </a>
                        </div>

                        <!-- Favicon Management Card -->
                        <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-6">
                            <div class="flex items-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                </svg>
                                <h4 class="text-lg font-medium">{{ __('Favicon Management') }}</h4>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                {{ __('Update your site favicon.') }}
                            </p>
                            <a href="{{ route('admin.content.favicon') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Manage Favicon') }}
                            </a>
                        </div>

                        <!-- Page Content Management Card -->
                        <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-6">
                            <div class="flex items-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h4 class="text-lg font-medium">{{ __('Page Content') }}</h4>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                {{ __('Edit content for various pages on your site.') }}
                            </p>
                            <a href="{{ route('admin.content.page-content') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Manage Page Content') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

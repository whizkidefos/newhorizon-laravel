<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        @if(auth()->user()->profile_photo)
                            <img src="{{ Storage::url(auth()->user()->profile_photo) }}" 
                                 alt="{{ auth()->user()->name }}" 
                                 class="h-20 w-20 rounded-full object-cover">
                        @endif
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ auth()->user()->email }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 border-t border-gray-200 dark:border-gray-700">
                        <dl class="divide-y divide-gray-200 dark:divide-gray-700">
                            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Job Role
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">
                                    {{ ucfirst(str_replace('_', ' ', auth()->user()->job_role)) }}
                                </dd>
                            </div>
                            <!-- Add other profile fields as needed -->
                        </dl>
                    </div>

                    <div class="mt-6 flex items-center justify-end">
                        <a href="{{ route('profile.edit') }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
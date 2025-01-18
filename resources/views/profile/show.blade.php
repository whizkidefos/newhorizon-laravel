@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                    Profile Information
                </h3>
                <x-button href="{{ route('profile.edit') }}" variant="primary">
                    Edit Profile
                </x-button>
            </div>
            
            <div class="border-t border-gray-200 dark:border-gray-700">
                <dl>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">
                            Full name
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">
                            {{ $user->first_name }} {{ $user->last_name }}
                        </dd>
                    </div>
                    <!-- Add other profile fields -->
                </dl>
            </div>
        </div>

        <!-- Certifications -->
        <div class="mt-8 bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                    Certifications
                </h3>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700">
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($user->certifications as $cert)
                        <li class="px-4 py-4">
                            <div class="flex justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $cert->name }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Expires: {{ $cert->expiry_date->format('d M Y') }}
                                    </p>
                                </div>
                                @if($cert->certificate_file)
                                    <a href="{{ Storage::url($cert->certificate_file) }}" 
                                       target="_blank"
                                       class="text-blue-600 hover:text-blue-800">
                                        View Certificate
                                    </a>
                                @endif
                            </div>
                        </li>
                    @empty
                        <li class="px-4 py-4 text-sm text-gray-500 dark:text-gray-400">
                            No certifications found.
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- References -->
        <div class="mt-8 bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                    References
                </h3>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700">
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($user->references as $ref)
                        <li class="px-4 py-4">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $ref->name }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $ref->email }} | {{ $ref->phone }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Relationship: {{ $ref->relationship }}
                                </p>
                            </div>
                        </li>
                    @empty
                        <li class="px-4 py-4 text-sm text-gray-500 dark:text-gray-400">
                            No references found.
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Change Password -->
        <div class="mt-8 bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                    Change Password
                </h3>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700">
                <form action="{{ route('profile.password.update') }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Current Password
                            </label>
                            <input type="password" 
                                   name="current_password" 
                                   id="current_password"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                New Password
                            </label>
                            <input type="password" 
                                   name="password" 
                                   id="password"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Confirm New Password
                            </label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   id="password_confirmation"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="flex justify-end">
                            <x-button type="submit" variant="primary">
                                Update Password
                            </x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
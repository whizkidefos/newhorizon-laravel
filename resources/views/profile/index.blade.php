@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-2xl font-semibold">Profile Information</h1>
                        <a href="{{ route('profile.edit') }}" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                            Edit Profile
                        </a>
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="space-y-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 overflow-hidden rounded-full">
                                    @if(Auth::user()->profile_photo_path)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" class="object-cover w-full h-full">
                                    @else
                                        <div class="flex items-center justify-center w-full h-full text-2xl text-white bg-blue-500">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h2 class="text-xl font-semibold">{{ Auth::user()->name }}</h2>
                                    <p class="text-gray-600 dark:text-gray-400">{{ Auth::user()->email }}</p>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium">Contact Information</h3>
                                <p class="mt-1 text-gray-600 dark:text-gray-400">Phone: {{ Auth::user()->phone ?? 'Not provided' }}</p>
                                <p class="text-gray-600 dark:text-gray-400">Address: {{ Auth::user()->address ?? 'Not provided' }}</p>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium">Employment Details</h3>
                                <p class="mt-1 text-gray-600 dark:text-gray-400">Employee ID: {{ Auth::user()->employee_id ?? 'Not assigned' }}</p>
                                <p class="text-gray-600 dark:text-gray-400">Department: {{ Auth::user()->department ?? 'Not assigned' }}</p>
                                <p class="text-gray-600 dark:text-gray-400">Position: {{ Auth::user()->position ?? 'Not assigned' }}</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <h3 class="text-lg font-medium">Account Status</h3>
                                <p class="mt-1 text-gray-600 dark:text-gray-400">Member since: {{ Auth::user()->created_at->format('F Y') }}</p>
                                <p class="text-gray-600 dark:text-gray-400">Last updated: {{ Auth::user()->updated_at->diffForHumans() }}</p>
                            </div>

                            @if(Auth::user()->roles)
                                <div>
                                    <h3 class="text-lg font-medium">Roles & Permissions</h3>
                                    <div class="mt-1 space-y-1">
                                        @foreach(Auth::user()->roles as $role)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 mt-8 md:grid-cols-3">
                        <a href="{{ route('profile.bank-details') }}" class="p-6 transition-colors bg-white border rounded-lg shadow-sm hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:hover:bg-gray-600">
                            <h3 class="text-lg font-semibold">Bank Details</h3>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Manage your bank account information for payments</p>
                        </a>

                        <a href="{{ route('profile.work-history') }}" class="p-6 transition-colors bg-white border rounded-lg shadow-sm hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:hover:bg-gray-600">
                            <h3 class="text-lg font-semibold">Work History</h3>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">View and update your employment history</p>
                        </a>

                        <a href="{{ route('profile.trainings') }}" class="p-6 transition-colors bg-white border rounded-lg shadow-sm hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:hover:bg-gray-600">
                            <h3 class="text-lg font-semibold">Training Records</h3>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Access your training certificates and records</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

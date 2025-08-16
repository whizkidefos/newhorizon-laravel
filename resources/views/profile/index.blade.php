@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success') || session('status') === 'profile-updated' || session('message'))
                <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 p-4 rounded-md">
                    {{ session('success') ?? session('message') ?? 'Profile updated successfully.' }}
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-2xl font-semibold">Profile Information</h1>
                        <div class="flex space-x-2">
                            <a href="{{ route('profile.export') }}" class="px-4 py-2 text-white bg-green-500 rounded-md hover:bg-green-600 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                                </svg>
                                Export Profile
                            </a>
                            <a href="{{ route('profile.edit') }}" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                Edit Profile
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="space-y-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 overflow-hidden rounded-full">
                                    @if(Auth::user()->profile_photo)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}" class="object-cover w-full h-full">
                                    @else
                                        <div class="flex items-center justify-center w-full h-full text-2xl text-white bg-blue-500">
                                            {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h2 class="text-xl font-semibold">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h2>
                                    <p class="text-gray-600 dark:text-gray-400">{{ Auth::user()->email }}</p>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium">Contact Information</h3>
                                <p class="mt-1 text-gray-600 dark:text-gray-400">Phone: {{ Auth::user()->mobile_number ?? 'Not provided' }}</p>
                                <p class="text-gray-600 dark:text-gray-400">
                                    Address: 
                                    @if(Auth::user()->profileDetail && Auth::user()->profileDetail->address_line_1)
                                        {{ Auth::user()->profileDetail->address_line_1 }}
                                        @if(Auth::user()->profileDetail->address_line_2), {{ Auth::user()->profileDetail->address_line_2 }}@endif
                                        @if(Auth::user()->profileDetail->city), {{ Auth::user()->profileDetail->city }}@endif
                                        @if(Auth::user()->profileDetail->county), {{ Auth::user()->profileDetail->county }}@endif
                                        @if(Auth::user()->profileDetail->postcode), {{ Auth::user()->profileDetail->postcode }}@endif
                                        @if(Auth::user()->profileDetail->country), {{ Auth::user()->profileDetail->country }}@endif
                                    @else
                                        Not provided
                                    @endif
                                </p>
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

                            <div>
                                <h3 class="text-lg font-medium">Professional Details</h3>
                                <p class="mt-1 text-gray-600 dark:text-gray-400">Job Role: {{ ucwords(str_replace('_', ' ', Auth::user()->job_role)) ?? 'Not specified' }}</p>
                                <p class="text-gray-600 dark:text-gray-400">NI Number: {{ Auth::user()->national_insurance_number ?? 'Not provided' }}</p>
                                <p class="text-gray-600 dark:text-gray-400">Nationality: {{ Auth::user()->nationality ?? 'Not specified' }}</p>
                                
                                <div class="mt-3">
                                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Documents Status</h4>
                                    <div class="mt-2 space-y-2">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                @if(Auth::user()->profile_photo)
                                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-green-100 text-green-600 dark:bg-green-800 dark:text-green-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                        </svg>
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                        </svg>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-gray-700 dark:text-gray-300">Profile Photo</p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                @if(Auth::user()->signature)
                                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-green-100 text-green-600 dark:bg-green-800 dark:text-green-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                        </svg>
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                        </svg>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-gray-700 dark:text-gray-300">Signature</p>
                                                @if(Auth::user()->signature_date)
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">Uploaded: {{ Auth::user()->signature_date->format('d M Y') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        @if(Auth::user()->has_enhanced_dbs)
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                @if(Auth::user()->dbs_certificate)
                                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-green-100 text-green-600 dark:bg-green-800 dark:text-green-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                        </svg>
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                        </svg>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-gray-700 dark:text-gray-300">DBS Certificate</p>
                                                @if(!Auth::user()->dbs_certificate)
                                                    <p class="text-xs text-yellow-600 dark:text-yellow-400">Required for enhanced DBS</p>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                        
                                        @if(Auth::user()->nationality && Auth::user()->nationality !== 'British')
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                @if(Auth::user()->brp_document)
                                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-green-100 text-green-600 dark:bg-green-800 dark:text-green-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                        </svg>
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                        </svg>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-gray-700 dark:text-gray-300">BRP Document</p>
                                                @if(!Auth::user()->brp_document)
                                                    <p class="text-xs text-yellow-600 dark:text-yellow-400">Required for non-British nationals</p>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
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

                        <a href="{{ route('profile.export') }}" class="p-6 transition-colors bg-white border rounded-lg shadow-sm hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:hover:bg-gray-600">
                            <h3 class="text-lg font-semibold">Export Profile</h3>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Download your profile data in various formats</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

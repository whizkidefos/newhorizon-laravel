@extends('layouts.frontend')

@section('title', 'Leading Healthcare Staffing Solutions in North Wales')
@section('meta_description', 'New Horizon Healthcare provides top-quality healthcare staffing solutions in North Wales and North West England.')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-blue-600 to-blue-800 dark:from-blue-800 dark:to-blue-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-4xl tracking-tight font-bold text-white sm:text-5xl md:text-6xl">
                    Healthcare Staffing Excellence
                </h1>
                <p class="mt-3 max-w-md mx-auto text-base text-blue-100 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    Your trusted partner in healthcare staffing across North Wales and North West England
                </p>
                <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                    <div class="rounded-md shadow">
                        <a href="{{ route('about') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10">
                            Learn More
                        </a>
                    </div>
                    <div class="mt-3 sm:mt-0 sm:ml-3">
                        <a href="{{ route('contact') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-500 bg-opacity-60 hover:bg-opacity-70 md:py-4 md:text-lg md:px-10">
                            Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Section -->
    <div class="py-12 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                    Our Healthcare Staffing Services
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 dark:text-gray-400 mx-auto">
                    Comprehensive staffing solutions for healthcare facilities
                </p>
            </div>

            <div class="mt-10">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Registered Nurses -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg px-6 py-8">
                        <div class="flex justify-center">
                            <!-- Add icon here -->
                        </div>
                        <div class="text-center mt-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Registered Nurses</h3>
                            <p class="mt-2 text-gray-500 dark:text-gray-400">
                                Experienced nursing professionals for various healthcare settings
                            </p>
                        </div>
                    </div>

                    <!-- Healthcare Assistants -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg px-6 py-8">
                        <div class="flex justify-center">
                            <!-- Add icon here -->
                        </div>
                        <div class="text-center mt-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Healthcare Assistants</h3>
                            <p class="mt-2 text-gray-500 dark:text-gray-400">
                                Dedicated support staff for patient care and assistance
                            </p>
                        </div>
                    </div>

                    <!-- Support Workers -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg px-6 py-8">
                        <div class="flex justify-center">
                            <!-- Add icon here -->
                        </div>
                        <div class="text-center mt-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Support Workers</h3>
                            <p class="mt-2 text-gray-500 dark:text-gray-400">
                                Professional care and support in various healthcare environments
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Why Choose Us Section -->
    <div class="py-12 bg-gray-50 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mt-10">
                <!-- Benefits/Features -->
                <div class="py-12 bg-gray-50 dark:bg-gray-800">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="text-center mb-12">
                            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                                Why Choose New Horizon Healthcare
                            </h2>
                        </div>

                        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                            <x-feature-card
                                title="Expert Recruitment"
                                description="Our experienced team ensures perfect matches between healthcare professionals and facilities."
                                icon="users" />

                            <x-feature-card
                                title="Quality Assurance"
                                description="Rigorous screening and verification processes to maintain high standards."
                                icon="shield-check" />

                            <x-feature-card
                                title="Comprehensive Support"
                                description="24/7 support for both healthcare professionals and facilities."
                                icon="support" />
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-blue-600 dark:bg-blue-800">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl text-center">
                Ready to Learn More?
            </h2>
            <p class="mt-6 max-w-lg mx-auto text-xl text-blue-100 text-center">
                Contact us today to discuss your healthcare staffing needs
            </p>
            <div class="mt-8 flex justify-center">
                <div class="inline-flex rounded-md shadow">
                    <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.frontend')

@section('title', 'About Us - New Horizon Healthcare')
@section('meta_description', 'Learn about New Horizon Healthcare\'s mission to provide exceptional healthcare staffing solutions in North Wales and North West England.')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-blue-600 to-blue-800 dark:from-blue-800 dark:to-blue-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-4xl tracking-tight font-bold text-white sm:text-5xl md:text-6xl">
                    About Us
                </h1>
                <p class="mt-3 max-w-md mx-auto text-base text-blue-100 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    Dedicated to excellence in healthcare staffing since 2020
                </p>
            </div>
        </div>
    </div>

    <!-- Mission & Vision -->
    <div class="py-16 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Our Mission</h2>
                    <p class="text-gray-600 dark:text-gray-400 text-lg leading-relaxed">
                        To provide exceptional healthcare staffing solutions that enhance the quality of patient care while creating rewarding opportunities for healthcare professionals.
                    </p>
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Our Vision</h2>
                    <p class="text-gray-600 dark:text-gray-400 text-lg leading-relaxed">
                        To be the leading healthcare staffing provider in North Wales and North West England, known for our commitment to excellence, integrity, and innovation.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="py-16 bg-gray-50 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <x-stat-counter number="500" suffix="+" label="Healthcare Professionals" />
                <x-stat-counter number="50" suffix="+" label="Partner Facilities" />
                <x-stat-counter number="10000" suffix="+" label="Shifts Completed" />
                <x-stat-counter number="98" suffix="%" label="Client Satisfaction" />
            </div>
        </div>
    </div>

    <!-- Our Journey -->
    <div class="py-16 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white text-center mb-12">Our Journey</h2>
            
            <x-timeline :items="[
                [
                    'date' => '2020',
                    'title' => 'Foundation',
                    'description' => 'New Horizon Healthcare was established to serve the healthcare community.'
                ],
                [
                    'date' => '2021',
                    'title' => 'Regional Expansion',
                    'description' => 'Expanded our services across North Wales.'
                ],
                [
                    'date' => '2022',
                    'title' => 'Digital Innovation',
                    'description' => 'Launched our digital platform for seamless staff management.'
                ],
                [
                    'date' => '2023',
                    'title' => 'Quality Recognition',
                    'description' => 'Achieved industry recognition for service excellence.'
                ]
            ]" />
        </div>
    </div>

    <!-- Team Values -->
    <div class="py-16 bg-gray-50 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white text-center mb-12">Our Values</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <x-feature-card
                    title="Excellence"
                    description="We strive for excellence in everything we do, from recruitment to service delivery."
                    icon="star" />
                    
                <x-feature-card
                    title="Integrity"
                    description="We maintain the highest standards of honesty and ethical conduct."
                    icon="shield-check" />
                    
                <x-feature-card
                    title="Innovation"
                    description="We embrace new technologies and methods to improve our services continuously."
                    icon="light-bulb" />
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-blue-600 dark:bg-blue-800">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">
                Join Our Growing Team
            </h2>
            <p class="text-xl text-blue-100 mb-8">
                Be part of our mission to provide exceptional healthcare services
            </p>
            <a href="{{ route('register') }}" 
               class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50">
                Apply Now
            </a>
        </div>
    </div>
@endsection
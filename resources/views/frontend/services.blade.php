@extends('layouts.frontend')

@section('title', 'Our Healthcare Services')
@section('meta_description', 'Comprehensive healthcare staffing services including registered nurses, healthcare assistants, and support workers across North Wales and North West England.')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-blue-600 to-blue-800 dark:from-blue-800 dark:to-blue-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-4xl tracking-tight font-bold text-white sm:text-5xl md:text-6xl">
                    Our Healthcare Services
                </h1>
                <p class="mt-3 max-w-md mx-auto text-base text-blue-100 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    Professional healthcare staffing solutions tailored to your needs
                </p>
            </div>
        </div>
    </div>

    <!-- Services Section -->
    <div class="py-16 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-12 lg:grid-cols-3">
                @foreach($services as $service)
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg overflow-hidden shadow-lg">
                        <div class="p-6">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                                {{ $service['title'] }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">
                                {{ $service['description'] }}
                            </p>
                            <ul class="space-y-3">
                                @foreach($service['features'] as $feature)
                                    <li class="flex items-center text-gray-600 dark:text-gray-300">
                                        <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        {{ $feature }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Benefits Section -->
    <div class="py-16 bg-gray-50 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Why Choose Our Services
                </h2>
                <p class="mt-4 text-gray-600 dark:text-gray-400">
                    We provide comprehensive support and opportunities for healthcare professionals
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <x-feature-card 
                    title="Flexible Scheduling" 
                    description="Choose shifts that fit your lifestyle with our flexible scheduling system"
                    icon="calendar" />

                <x-feature-card 
                    title="Competitive Pay" 
                    description="Excellent rates and additional benefits for our healthcare professionals"
                    icon="currency-pound" />

                <x-feature-card 
                    title="Professional Development" 
                    description="Access to training and development opportunities to enhance your career"
                    icon="academic-cap" />

                <x-feature-card 
                    title="24/7 Support" 
                    description="Round-the-clock support for all our healthcare professionals"
                    icon="phone" />

                <x-feature-card 
                    title="Quick Payments" 
                    description="Reliable and timely payment processing for all shifts worked"
                    icon="credit-card" />

                <x-feature-card 
                    title="Quality Placements" 
                    description="Carefully selected healthcare facilities matching your skills and preferences"
                    icon="building-office" />
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-blue-600 dark:bg-blue-800">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">
                Ready to Join Our Team?
            </h2>
            <p class="text-xl text-blue-100 mb-8">
                Start your journey with New Horizon Healthcare today
            </p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('register') }}" 
                   class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50">
                    Register Now
                </a>
                <a href="{{ route('contact') }}" 
                   class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-500 bg-opacity-60 hover:bg-opacity-70">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
@endsection
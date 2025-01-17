@extends('layouts.frontend')

@section('title', 'Leading Healthcare Staffing Solutions in North Wales')
@section('meta_description', 'New Horizon Healthcare provides top-quality healthcare staffing solutions in North Wales and North West England, including nurses, care assistants, and support workers.')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-blue-600 to-blue-800">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
            <div class="relative">
                <div class="mt-12 lg:mt-0 lg:col-span-2">
                    <div class="text-center text-white">
                        <h1 class="text-4xl tracking-tight font-extrabold sm:text-5xl md:text-6xl">
                            Healthcare Staffing Excellence
                        </h1>
                        <p class="mt-3 max-w-md mx-auto text-lg text-blue-100 sm:text-xl md:mt-5 md:max-w-3xl">
                            Join North Wales' premier healthcare staffing agency. Flexible shifts, competitive pay, and support for your career growth.
                        </p>
                        <div class="mt-10 sm:flex sm:justify-center">
                            <div class="rounded-md shadow">
                                <a href="{{ route('register') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50 md:py-4 md:text-lg md:px-10">
                                    Join Our Team
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                <a href="{{ route('about') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-500 bg-opacity-60 hover:bg-opacity-70 md:py-4 md:text-lg md:px-10">
                                    Learn More
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Jobs Section -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Featured Opportunities
                </h2>
            </div>
            <div class="mt-10">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($featuredJobs as $job)
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                            <!-- Job card content -->
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="bg-blue-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    What Our Healthcare Professionals Say
                </h2>
            </div>
            <div class="mt-10">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($testimonials as $testimonial)
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden p-6">
                            <div class="text-gray-600">"{{ $testimonial['content'] }}"</div>
                            <div class="mt-4">
                                <div class="font-medium text-gray-900">{{ $testimonial['name'] }}</div>
                                <div class="text-blue-600">{{ $testimonial['role'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-blue-700">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    Ready to Join Our Team?
                </h2>
                <p class="mt-4 text-lg leading-6 text-blue-100">
                    Start your journey with New Horizon Healthcare today.
                </p>
                <div class="mt-8">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50">
                        Register Now
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
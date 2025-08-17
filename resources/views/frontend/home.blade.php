@extends('layouts.frontend')

@section('title', 'Leading Healthcare Staffing Solutions in North Wales')
@section('meta_description', 'New Horizon Healthcare provides top-quality healthcare staffing solutions in North Wales and North West England.')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900 overflow-hidden py-16 md:py-24">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-grid-white/[0.05] bg-[size:60px_60px]"></div>
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-blue-900/50 to-transparent"></div>
        
        <!-- Animated Circles -->
        <div class="absolute top-0 left-0 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute top-0 right-0 w-72 h-72 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-0 left-1/2 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>

        <div class="max-w-7xl mx-auto relative">
            <div class="relative z-10">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
                        <!-- Text Content -->
                        <div class="text-center lg:text-left lg:w-1/2">
                            <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                                <span class="block mb-2">Transforming</span>
                                <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-white">Healthcare</span>
                                <span class="block text-2xl sm:text-3xl mt-4 text-blue-200">
                                    Through
                                    <span class="inline-flex flex-col h-[1.25em] overflow-hidden">
                                        <span class="animate-text-slide text-center">
                                            Innovation<br/>
                                            Excellence<br/>
                                            Partnership<br/>
                                            Leadership<br/>
                                            Innovation
                                        </span>
                                    </span>
                                </span>
                            </h1>
                            <p class="mt-6 text-lg text-blue-100 max-w-xl mx-auto lg:mx-0">
                                Empowering healthcare facilities with exceptional talent and transformative staffing solutions across North Wales and North West England.
                            </p>
                            
                            <!-- CTAs -->
                            <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                                <a href="{{ route('jobs.index') }}" 
                                   class="inline-flex items-center px-6 py-3 border-2 border-transparent text-base font-medium rounded-lg text-blue-900 bg-white hover:bg-blue-50 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                                    <span>Find Your Next Role</span>
                                    <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </a>
                                <a href="{{ route('contact') }}" 
                                   class="inline-flex items-center px-6 py-3 border-2 border-white text-base font-medium rounded-lg text-white hover:bg-white/10 transform hover:scale-105 transition-all duration-200">
                                    <span>Contact Us</span>
                                    <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Hero Image/Illustration -->
                        <div class="hidden lg:block lg:w-1/2">
                            <div class="relative mx-auto w-full max-w-md">
                                <div class="relative">
                                    <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" 
                                         alt="Healthcare Professional" 
                                         class="relative rounded-2xl shadow-2xl w-full h-[450px] object-cover object-center"
                                    >
                                    <div class="absolute inset-0 rounded-2xl bg-gradient-to-t from-blue-900/50 to-transparent"></div>
                                </div>
                                <!-- Stats Card -->
                                <div class="absolute -bottom-6 -left-6 bg-white dark:bg-gray-800 rounded-xl shadow-xl p-4 backdrop-blur-sm bg-opacity-90 dark:bg-opacity-90">
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Trusted by</p>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white">100+ Partners</p>
                                </div>
                                <!-- Experience Card -->
                                <div class="absolute -top-6 -right-6 bg-blue-600 rounded-xl shadow-xl p-4">
                                    <p class="text-sm font-medium text-blue-100">Experience</p>
                                    <p class="text-2xl font-bold text-white">15+ Years</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Why Choose Us 2 -->
    <div class="bg-gray-50 dark:bg-gray-800 py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">Why Choose Us</h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">What sets New Horizon Healthcare apart from the rest.</p>
            </div>
            <div class="mt-20 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <div class="text-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mx-auto">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Quality Assured</h3>
                    <p class="mt-2 text-base text-gray-500 dark:text-gray-400">Rigorous vetting process for all healthcare professionals.</p>
                </div>
                <div class="text-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mx-auto">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">24/7 Support</h3>
                    <p class="mt-2 text-base text-gray-500 dark:text-gray-400">Round-the-clock assistance for our clients and staff.</p>
                </div>
                <div class="text-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mx-auto">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Fast Response</h3>
                    <p class="mt-2 text-base text-gray-500 dark:text-gray-400">Quick turnaround times for all staffing requests.</p>
                </div>
                <div class="text-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mx-auto">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Expert Team</h3>
                    <p class="mt-2 text-base text-gray-500 dark:text-gray-400">Experienced professionals dedicated to your success.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Section -->
    <div class="py-12 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12 py-10">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                    Our Healthcare Staffing Services
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 dark:text-gray-400 mx-auto">
                    Comprehensive staffing solutions for healthcare facilities
                </p>
            </div>

            <div class="mt-20 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Registered Nurses -->
                <div class="relative group transform hover:scale-105 transition-transform duration-200">
                    <div class="relative rounded-lg overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-600 opacity-75"></div>
                        <img src="https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Registered Nurses" class="w-full h-48 object-cover">
                        <div class="relative p-6">
                            <h3 class="text-lg font-semibold text-white">Registered Nurses</h3>
                            <p class="mt-2 text-sm text-blue-100">Expert nursing professionals for various healthcare settings.</p>
                        </div>
                    </div>
                </div>
                <!-- Healthcare Assistants -->
                <div class="relative group transform hover:scale-105 transition-transform duration-200">
                    <div class="relative rounded-lg overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-600 opacity-75"></div>
                        <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Healthcare Assistants" class="w-full h-48 object-cover">
                        <div class="relative p-6">
                            <h3 class="text-lg font-semibold text-white">Healthcare Assistants</h3>
                            <p class="mt-2 text-sm text-blue-100">Dedicated support staff for patient care and assistance.</p>
                        </div>
                    </div>
                </div>
                <!-- Support Workers -->
                <div class="relative group transform hover:scale-105 transition-transform duration-200">
                    <div class="relative rounded-lg overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-600 opacity-75"></div>
                        <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Support Workers" class="w-full h-48 object-cover">
                        <div class="relative p-6">
                            <h3 class="text-lg font-semibold text-white">Support Workers</h3>
                            <p class="mt-2 text-sm text-blue-100">Compassionate care workers for community and residential settings.</p>
                        </div>
                    </div>
                </div>
                <!-- Temporary Staffing -->
                <div class="relative group transform hover:scale-105 transition-transform duration-200">
                    <div class="relative rounded-lg overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-600 opacity-75"></div>
                        <img src="https://images.unsplash.com/photo-1631217868264-e5b90bb7e133?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Temporary Staffing" class="w-full h-48 object-cover">
                        <div class="relative p-6">
                            <h3 class="text-lg font-semibold text-white">Temporary Staffing</h3>
                            <p class="mt-2 text-sm text-blue-100">Flexible staffing solutions for healthcare needs.</p>
                        </div>
                    </div>
                </div>
                <!-- Permanent Recruitment -->
                <div class="relative group transform hover:scale-105 transition-transform duration-200">
                    <div class="relative rounded-lg overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-600 opacity-75"></div>
                        <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Permanent Recruitment" class="w-full h-48 object-cover">
                        <div class="relative p-6">
                            <h3 class="text-lg font-semibold text-white">Permanent Recruitment</h3>
                            <p class="mt-2 text-sm text-blue-100">Long-term staffing solutions for healthcare facilities.</p>
                        </div>
                    </div>
                </div>
                <!-- Contract Staffing -->
                <div class="relative group transform hover:scale-105 transition-transform duration-200">
                    <div class="relative rounded-lg overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-600 opacity-75"></div>
                        <img src="https://images.unsplash.com/photo-1582750433449-648ed127bb54?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Contract Staffing" class="w-full h-48 object-cover">
                        <div class="relative p-6">
                            <h3 class="text-lg font-semibold text-white">Contract Staffing</h3>
                            <p class="mt-2 text-sm text-blue-100">Professional healthcare staff for fixed-term projects.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">Our Impact in Numbers</h2>
                <p class="mt-4 text-xl text-blue-100">Making a difference in healthcare staffing across North Wales and North West England</p>
            </div>
            <div class="grid grid-cols-2 gap-8 md:gap-12 md:grid-cols-4">
                <!-- Healthcare Professionals Counter -->
                <div class="text-center transform hover:scale-105 transition-all duration-300 bg-white/10 rounded-lg p-6 backdrop-blur-sm">
                    <div class="text-5xl font-extrabold text-white mb-2">
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-100 to-white">500+</span>
                    </div>
                    <div class="text-lg text-blue-100">Healthcare Professionals</div>
                    <div class="mt-2 text-sm text-blue-200">Placed in the last year</div>
                </div>
                
                <!-- Partner Facilities Counter -->
                <div class="text-center transform hover:scale-105 transition-all duration-300 bg-white/10 rounded-lg p-6 backdrop-blur-sm">
                    <div class="text-5xl font-extrabold text-white mb-2">
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-100 to-white">100+</span>
                    </div>
                    <div class="text-lg text-blue-100">Partner Facilities</div>
                    <div class="mt-2 text-sm text-blue-200">Trusted partnerships</div>
                </div>
                
                <!-- Years Experience Counter -->
                <div class="text-center transform hover:scale-105 transition-all duration-300 bg-white/10 rounded-lg p-6 backdrop-blur-sm">
                    <div class="text-5xl font-extrabold text-white mb-2">
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-100 to-white">15+</span>
                    </div>
                    <div class="text-lg text-blue-100">Years Experience</div>
                    <div class="mt-2 text-sm text-blue-200">Industry expertise</div>
                </div>
                
                <!-- Client Satisfaction Counter -->
                <div class="text-center transform hover:scale-105 transition-all duration-300 bg-white/10 rounded-lg p-6 backdrop-blur-sm">
                    <div class="text-5xl font-extrabold text-white mb-2">
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-100 to-white">98%</span>
                    </div>
                    <div class="text-lg text-blue-100">Client Satisfaction</div>
                    <div class="mt-2 text-sm text-blue-200">Consistently rated</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <!-- <div class="bg-blue-600 dark:bg-blue-800">
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
    </div> -->
@endsection
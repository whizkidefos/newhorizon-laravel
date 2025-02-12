<x-app-layout>
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-blue-600 to-blue-800">
        <div class="absolute inset-0">
            <img src="{{ asset('images/hero-bg.jpg') }}" alt="Healthcare professionals" class="w-full h-full object-cover opacity-20">
        </div>
        <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">Healthcare Staffing Solutions</h1>
            <p class="mt-6 text-xl text-blue-100 max-w-3xl">Connecting healthcare professionals with leading facilities across North Wales and North West England.</p>
            <div class="mt-10 flex flex-col gap-4">
                <!-- Search Bar -->
                <div class="max-w-2xl w-full mx-auto">
                    <form action="{{ route('jobs.search') }}" method="GET" class="flex gap-2">
                        <input type="text" name="query" placeholder="Search for jobs..." class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Search
                        </button>
                    </form>
                </div>
                <!-- CTA Buttons -->
                <div class="flex justify-center gap-4">
                    <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50 transform hover:scale-105 transition-transform duration-200">
                        Join Our Team
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-500 hover:bg-blue-600 transform hover:scale-105 transition-transform duration-200">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Section -->
    <div class="py-24 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">Our Services</h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">Comprehensive healthcare staffing solutions tailored to your needs.</p>
            </div>
            <div class="mt-20 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Temporary Staffing -->
                <div class="relative group transform hover:scale-105 transition-transform duration-200">
                    <div class="relative rounded-lg overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-600 opacity-75"></div>
                        <img src="https://images.unsplash.com/photo-1631217868264-e5b90bb7e133?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Temporary Staffing" class="w-full h-48 object-cover">
                        <div class="relative p-6">
                            <h3 class="text-lg font-semibold text-white">Temporary Staffing</h3>
                            <p class="mt-2 text-sm text-blue-100">Flexible staffing solutions for healthcare facilities.</p>
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
                            <p class="mt-2 text-sm text-blue-100">Finding the perfect long-term match for your facility.</p>
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
                            <p class="mt-2 text-sm text-blue-100">Professional healthcare staff for fixed-term contracts.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Why Choose Us -->
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

    <!-- Featured Jobs -->
    <div class="bg-white dark:bg-gray-900 py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">Featured Opportunities</h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">Latest healthcare positions available now.</p>
            </div>
            <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($featuredJobs ?? [] as $job)
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $job->title }}</h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ $job->location }}</p>
                        <div class="mt-4">
                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $job->type }}
                            </span>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('jobs.show', $job) }}" class="text-blue-600 hover:text-blue-500 font-medium">
                                View Details →
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-12 text-center">
                <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    View All Jobs
                </a>
            </div>
        </div>
    </div>

    <!-- Testimonials -->
    <div class="bg-gray-50 dark:bg-gray-800 py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">What Our Clients Say</h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">Trusted by healthcare facilities across the region.</p>
            </div>
            
            <div class="mt-12 relative" x-data="{ currentSlide: 0 }" @keydown.right="currentSlide = (currentSlide + 1) % 3" @keydown.left="currentSlide = (currentSlide - 1 + 3) % 3">
                <div class="flex overflow-hidden">
                    <template x-for="(testimonial, index) in [
                        {
                            quote: 'New Horizon Healthcare has consistently provided us with top-quality healthcare professionals. Their service is unmatched.',
                            author: 'Dr. Sarah Johnson',
                            role: 'Medical Director',
                            image: '/images/testimonial-1.jpg'
                        },
                        {
                            quote: 'The level of professionalism and support we receive from New Horizon is exceptional. They understand our needs perfectly.',
                            author: 'James Wilson',
                            role: 'HR Manager',
                            image: '/images/testimonial-2.jpg'
                        },
                        {
                            quote: 'Working with New Horizon has transformed our staffing process. They are reliable, efficient, and always deliver.',
                            author: 'Emma Thompson',
                            role: 'Facility Administrator',
                            image: '/images/testimonial-3.jpg'
                        }
                    ]" :key="index">
                        <div class="w-full flex-shrink-0 transform transition-transform duration-500" :style="{ transform: `translateX(-${currentSlide * 100}%)` }">
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 mx-4">
                                <div class="flex items-center mb-8">
                                    <img :src="testimonial.image" :alt="testimonial.author" class="w-16 h-16 rounded-full object-cover">
                                    <div class="ml-4">
                                        <div class="text-lg font-semibold text-gray-900 dark:text-white" x-text="testimonial.author"></div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400" x-text="testimonial.role"></div>
                                    </div>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 italic" x-text="testimonial.quote"></p>
                            </div>
                        </div>
                    </template>
                </div>
                
                <!-- Navigation Buttons -->
                <button @click="currentSlide = (currentSlide - 1 + 3) % 3" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white dark:bg-gray-800 rounded-full p-2 shadow-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button @click="currentSlide = (currentSlide + 1) % 3" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white dark:bg-gray-800 rounded-full p-2 shadow-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="bg-blue-700 py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 gap-8 md:grid-cols-4">
                <div class="text-center transform hover:scale-105 transition-transform duration-200" x-data="{ shown: false, count: 0 }" x-intersect="shown = true; if (shown) { const interval = setInterval(() => { count = Math.min(count + 5, 500); if (count === 500) clearInterval(interval); }, 20); }">
                    <div class="text-4xl font-extrabold text-white">
                        <span x-text="count + '+'">0+</span>
                    </div>
                    <div class="mt-2 text-xl text-blue-100">Healthcare Professionals</div>
                </div>
                <div class="text-center transform hover:scale-105 transition-transform duration-200" x-data="{ shown: false, count: 0 }" x-intersect="shown = true; if (shown) { const interval = setInterval(() => { count = Math.min(count + 2, 100); if (count === 100) clearInterval(interval); }, 20); }">
                    <div class="text-4xl font-extrabold text-white">
                        <span x-text="count + '+'">0+</span>
                    </div>
                    <div class="mt-2 text-xl text-blue-100">Partner Facilities</div>
                </div>
                <div class="text-center transform hover:scale-105 transition-transform duration-200" x-data="{ shown: false, count: 0 }" x-intersect="shown = true; if (shown) { const interval = setInterval(() => { count = Math.min(count + 1, 15); if (count === 15) clearInterval(interval); }, 100); }">
                    <div class="text-4xl font-extrabold text-white">
                        <span x-text="count + '+'">0+</span>
                    </div>
                    <div class="mt-2 text-xl text-blue-100">Years Experience</div>
                </div>
                <div class="text-center transform hover:scale-105 transition-transform duration-200" x-data="{ shown: false, count: 0 }" x-intersect="shown = true; if (shown) { const interval = setInterval(() => { count = Math.min(count + 2, 98); if (count === 98) clearInterval(interval); }, 20); }">
                    <div class="text-4xl font-extrabold text-white">
                        <span x-text="count + '%'">0%</span>
                    </div>
                    <div class="mt-2 text-xl text-blue-100">Client Satisfaction</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest News -->
    <div class="bg-white dark:bg-gray-900 py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">Latest News</h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">Stay updated with healthcare industry news and insights.</p>
            </div>
            <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($latestNews ?? [] as $news)
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                    <img src="{{ $news->image }}" alt="{{ $news->title }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $news->title }}</h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($news->excerpt, 100) }}</p>
                        <div class="mt-6">
                            <a href="{{ route('news.show', $news) }}" class="text-blue-600 hover:text-blue-500 font-medium">
                                Read More →
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Contact CTA -->
    <div class="bg-blue-600">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                <span class="block">Ready to get started?</span>
                <span class="block text-blue-200">Get in touch with us today.</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                    <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50">
                        Contact Us
                    </a>
                </div>
                <div class="ml-3 inline-flex rounded-md shadow">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-500 hover:bg-blue-600">
                        Join Our Team
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    @section('title', $job->title)
    @section('meta_description', Str::limit(strip_tags($job->description), 160))

    <div class="bg-gray-100 dark:bg-gray-900 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                <!-- Job Header -->
                <div class="relative">
                    <div class="h-48 bg-gradient-to-r from-blue-600 to-blue-800"></div>
                    <div class="absolute bottom-0 left-0 right-0 px-6 py-4 bg-gradient-to-t from-black/60">
                        <h1 class="text-3xl font-bold text-white">{{ $job->title }}</h1>
                        <div class="mt-2 flex flex-wrap gap-4 text-white">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $job->location }}
                            </div>
                            <div class="flex items-center">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                {{ $job->type }}
                            </div>
                            @if($job->salary)
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $job->salary }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Job Content -->
                <div class="p-6">
                    <!-- Description -->
                    <div class="prose dark:prose-invert max-w-none">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Job Description</h2>
                        {{ $job->description }}
                    </div>

                    <!-- Requirements -->
                    @if($job->requirements)
                        <div class="mt-8">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Requirements</h2>
                            <ul class="list-disc list-inside space-y-2 text-gray-600 dark:text-gray-300">
                                @foreach($job->requirements as $requirement)
                                    <li>{{ $requirement }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Benefits -->
                    @if($job->benefits)
                        <div class="mt-8">
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Benefits</h2>
                            <ul class="list-disc list-inside space-y-2 text-gray-600 dark:text-gray-300">
                                @foreach($job->benefits as $benefit)
                                    <li>{{ $benefit }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Apply Button -->
                    <div class="mt-8 flex justify-center">
                        <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transform hover:scale-105 transition-transform duration-200">
                            Apply Now
                            <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Related Jobs -->
            <div class="mt-12">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Similar Jobs</h2>
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($relatedJobs ?? [] as $relatedJob)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-200">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $relatedJob->title }}</h3>
                                <div class="flex items-center text-gray-500 dark:text-gray-400 mb-2">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $relatedJob->location }}
                                </div>
                                <a href="{{ route('jobs.show', $relatedJob) }}" class="text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                                    View Details →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

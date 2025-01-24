@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="relative">
                @if($course->image_url)
                    <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="w-full h-64 object-cover">
                @else
                    <div class="w-full h-64 bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </div>
                @endif
                @if($enrollment)
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1.5 text-sm font-semibold rounded-full 
                            @if($enrollment->pivot->progress == 100) bg-green-100 text-green-800
                            @elseif($enrollment->pivot->progress > 0) bg-blue-100 text-blue-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ $enrollment->pivot->progress }}% Complete
                        </span>
                    </div>
                @endif
            </div>

            <div class="p-6">
                <div class="lg:flex lg:items-start lg:justify-between">
                    <div class="lg:flex-1">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $course->title }}</h2>
                        <div class="mt-4 flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $course->duration }} hours
                        </div>
                    </div>

                    <div class="mt-6 lg:mt-0 lg:ml-6 lg:flex-shrink-0">
                        @if($enrollment)
                            <a href="{{ route('courses.progress', $course) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Continue Learning
                            </a>
                        @else
                            <div class="flex flex-col space-y-4">
                                <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">£{{ number_format($course->price, 2) }}</p>
                                <form action="{{ route('courses.enroll', $course) }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Method</label>
                                        <select id="payment_method" name="payment_method" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                            <option value="credit_card">Credit Card</option>
                                            <option value="paypal">PayPal</option>
                                            <option value="bank_transfer">Bank Transfer</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Enroll Now
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-8 prose dark:prose-invert max-w-none">
                    {!! $course->description !!}
                </div>

                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Course Content</h3>
                    <div class="mt-4 space-y-4">
                        @foreach($course->modules as $module)
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <h4 class="text-base font-medium text-gray-900 dark:text-gray-100">{{ $module->title }}</h4>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $module->description }}</p>
                                
                                <div class="mt-3 space-y-2">
                                    @foreach($module->lessons as $lesson)
                                        <div class="flex items-center text-sm">
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-gray-700 dark:text-gray-300">{{ $lesson->title }}</span>
                                            <span class="ml-auto text-gray-500 dark:text-gray-400">{{ $lesson->duration }} min</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if($course->requirements)
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Requirements</h3>
                        <div class="mt-4 prose dark:prose-invert">
                            {!! $course->requirements !!}
                        </div>
                    </div>
                @endif

                @if($course->what_you_will_learn)
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">What You Will Learn</h3>
                        <div class="mt-4 prose dark:prose-invert">
                            {!! $course->what_you_will_learn !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

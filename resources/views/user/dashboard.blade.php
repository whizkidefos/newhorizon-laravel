@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Upcoming Shifts -->
                    <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold mb-2">Upcoming Shifts</h3>
                        @forelse($upcomingShifts as $shift)
                            <div class="p-2 bg-white dark:bg-gray-700 rounded mb-2">
                                <p class="font-medium">{{ $shift->location }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    {{ $shift->start_datetime->format('d M Y, H:i') }}
                                </p>
                                @if(!$shift->checked_in)
                                    <form action="{{ route('shifts.checkin', $shift) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">
                                            Check In
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @empty
                            <p class="text-gray-600 dark:text-gray-400">No upcoming shifts</p>
                        @endforelse
                    </div>

                    <!-- Completed Shifts -->
                    <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold mb-2">Completed Shifts</h3>
                        @forelse($completedShifts as $shift)
                            <div class="p-2 bg-white dark:bg-gray-700 rounded mb-2">
                                <p class="font-medium">{{ $shift->location }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    {{ $shift->end_datetime->format('d M Y, H:i') }}
                                </p>
                            </div>
                        @empty
                            <p class="text-gray-600 dark:text-gray-400">No completed shifts</p>
                        @endforelse
                    </div>

                    <!-- Available Courses -->
                    <div class="bg-purple-50 dark:bg-purple-900 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold mb-2">Available Courses</h3>
                        @forelse($availableCourses as $course)
                            <div class="p-2 bg-white dark:bg-gray-700 rounded mb-2">
                                <p class="font-medium">{{ $course->name }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    £{{ number_format($course->price, 2) }}
                                </p>
                                <a href="{{ route('courses.show', $course) }}" 
                                   class="mt-2 inline-block bg-purple-500 text-white px-4 py-2 rounded">
                                    View Details
                                </a>
                            </div>
                        @empty
                            <p class="text-gray-600 dark:text-gray-400">No courses available</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
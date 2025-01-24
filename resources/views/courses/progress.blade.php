@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-2xl font-semibold">{{ $course->title }}</h2>
                        <p class="text-gray-500 dark:text-gray-400 mt-1">Course Progress</p>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">
                            {{ $enrollment->pivot->progress }}%
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Complete</p>
                    </div>
                </div>

                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 mb-6">
                    <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $enrollment->pivot->progress }}%"></div>
                </div>

                <div class="space-y-8">
                    @foreach($modules as $module)
                        <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $module->title }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">{{ $module->description }}</p>

                                <div class="mt-4 space-y-4">
                                    @foreach($module->lessons as $lesson)
                                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-600 rounded-lg">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    @if($lesson->completions_count)
                                                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    @else
                                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $lesson->title }}</h4>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $lesson->duration }} minutes</p>
                                                </div>
                                            </div>
                                            <div>
                                                <button type="button" 
                                                        onclick="updateProgress('{{ route('courses.progress.update', ['course' => $course->id]) }}', {{ $lesson->id }}, {{ $lesson->completions_count ? 'false' : 'true' }})"
                                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm 
                                                        @if($lesson->completions_count)
                                                            text-indigo-600 bg-indigo-100 hover:bg-indigo-200
                                                        @else
                                                            text-white bg-indigo-600 hover:bg-indigo-700
                                                        @endif
                                                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    {{ $lesson->completions_count ? 'Mark Incomplete' : 'Mark Complete' }}
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateProgress(url, lessonId, completed) {
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            lesson_id: lessonId,
            completed: completed
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Reload the page to show updated progress
            window.location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to update progress. Please try again.');
    });
}
</script>
@endpush
@endsection

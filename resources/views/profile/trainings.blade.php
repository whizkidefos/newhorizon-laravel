<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Trainings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($trainings->count() > 0)
                        <div class="space-y-6">
                            @foreach($trainings as $training)
                                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                                    <div class="space-y-2">
                                        <div>
                                            <h3 class="text-lg font-medium">{{ $training->title }}</h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $training->provider }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                Completed: {{ \Carbon\Carbon::parse($training->completion_date)->format('M d, Y') }}
                                            </p>
                                        </div>
                                        <div>
                                            <p>{{ $training->description }}</p>
                                        </div>
                                        @if($training->certificate_url)
                                            <div>
                                                <a href="{{ $training->certificate_url }}" target="_blank" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200">
                                                    View Certificate
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{ $trainings->links() }}
                    @else
                        <p>No trainings found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

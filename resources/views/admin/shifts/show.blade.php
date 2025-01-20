<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
                Shift Details
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('admin.shifts.edit', $shift) }}" 
                   class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Edit Shift
                </a>
                @if($shift->status === 'checked_in')
                    <a href="{{ route('admin.shifts.track', $shift) }}"
                       class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                        Track Location
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Shift Information -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                Shift Information
            </h3>
            
            <dl class="grid grid-cols-1 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                    <dd class="mt-1">
                        <x-shift-status :status="$shift->status" />
                    </dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Date & Time</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                        {{ $shift->start_datetime->format('d M Y, H:i') }} - 
                        {{ $shift->end_datetime->format('H:i') }}
                        <span class="text-gray-500">
                            ({{ $shift->duration }} hours)
                        </span>
                    </dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Location</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                        {{ $shift->location }}
                    </dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Rate</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                        £{{ number_format($shift->rate_per_hour, 2) }}/hour
                    </dd>
                </div>

                @if($shift->notes)
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Notes</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ $shift->notes }}
                        </dd>
                    </div>
                @endif
            </dl>
        </div>

        <!-- Staff Information -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                Staff Information
            </h3>

            @if($shift->user)
                <div class="flex items-center mb-4">
                    <img src="{{ $shift->user->profile_photo_url }}" 
                         alt="{{ $shift->user->full_name }}"
                         class="h-12 w-12 rounded-full object-cover">
                    <div class="ml-4">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $shift->user->full_name }}
                        </h4>
                        <p class="text-sm text-gray-500">
                            {{ ucfirst($shift->user->job_role) }}
                        </p>
                    </div>
                </div>

                <dl class="grid grid-cols-1 gap-4">
                    @if($shift->checkin_time)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Check-in Time</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $shift->checkin_time->format('H:i') }}
                            </dd>
                        </div>
                    @endif

                    @if($shift->checkout_time)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Check-out Time</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $shift->checkout_time->format('H:i') }}
                            </dd>
                        </div>
                    @endif
                </dl>
            @else
                <div class="text-center py-4">
                    <p class="text-sm text-gray-500">No staff assigned</p>
                    <button onclick="showAssignModal()" 
                            class="mt-2 text-blue-600 hover:text-blue-500">
                        Assign Staff
                    </button>
                </div>
            @endif
        </div>

        <!-- Activity Timeline -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                Activity Timeline
            </h3>

            <div class="flow-root">
                <ul class="-mb-8">
                    @foreach($shift->activities as $activity)
                        <li>
                            <div class="relative pb-8">
                                @if(!$loop->last)
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700"></span>
                                @endif
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white dark:ring-gray-800 bg-blue-500">
                                            <!-- Activity Icon -->
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $activity->description }}
                                            </p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                            {{ $activity->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Assign Staff Modal -->
    <div x-data="{ open: false }"
         x-show="open"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title"
         role="dialog"
         aria-modal="true">
        <!-- Modal content -->
    </div>

    @push('scripts')
    <script>
        function showAssignModal() {
            // Modal logic
        }
    </script>
    @endpush
</x-admin-layout>
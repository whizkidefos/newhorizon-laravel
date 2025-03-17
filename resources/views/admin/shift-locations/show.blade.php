<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
                Location Details: {{ $shiftLocation->name }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('admin.shift-locations.edit', $shiftLocation) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.shift-locations.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Locations
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                                Location Information
                            </h3>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <div class="mb-4">
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</p>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $shiftLocation->name }}</p>
                                </div>
                                <div class="mb-4">
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Address</p>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $shiftLocation->address ?? 'N/A' }}</p>
                                </div>
                                <div class="mb-4">
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</p>
                                    <p class="mt-1">
                                        @if($shiftLocation->is_active)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                Active
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                                                Inactive
                                            </span>
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Created At</p>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $shiftLocation->created_at->format('M d, Y H:i A') }}</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                                Associated Shifts
                            </h3>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                @if($shiftLocation->shifts->isEmpty())
                                    <p class="text-sm text-gray-500 dark:text-gray-400">No shifts are currently associated with this location.</p>
                                @else
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                            <thead>
                                                <tr>
                                                    <th class="px-4 py-2 bg-gray-100 dark:bg-gray-600 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                                    <th class="px-4 py-2 bg-gray-100 dark:bg-gray-600 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                                    <th class="px-4 py-2 bg-gray-100 dark:bg-gray-600 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                                @foreach($shiftLocation->shifts->take(5) as $shift)
                                                    <tr>
                                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                            {{ $shift->start_datetime->format('M d, Y') }}
                                                        </td>
                                                        <td class="px-4 py-2 whitespace-nowrap text-sm">
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                                @if($shift->status === 'open') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                                                @elseif($shift->status === 'assigned') bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100
                                                                @elseif($shift->status === 'completed') bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100
                                                                @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                                                @endif">
                                                                {{ ucfirst($shift->status) }}
                                                            </span>
                                                        </td>
                                                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium">
                                                            <a href="{{ route('admin.shifts.show', $shift) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                                View
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @if($shiftLocation->shifts->count() > 5)
                                            <div class="mt-2 text-right">
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    Showing 5 of {{ $shiftLocation->shifts->count() }} shifts
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
                User Profile: {{ $user->first_name }} {{ $user->last_name }}
            </h1>
            <p class="text-gray-500">Member since {{ $user->created_at->format('d M Y') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.users.edit', $user) }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Edit Profile
            </a>
            <a href="{{ route('admin.users.export-pdf', $user) }}" 
               class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                Export PDF
            </a>
        </div>
    </div>

    <!-- Profile Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Basic Information -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Basic Information</h2>
            <dl class="grid grid-cols-1 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                        {{ $user->first_name }} {{ $user->last_name }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Phone</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->mobile_phone }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Job Role</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->job_role }}</dd>
                </div>
            </dl>
        </div>

        <!-- Certifications -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Certifications</h2>
            @if($user->certifications->count() > 0)
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($user->certifications as $cert)
                    <li class="py-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $cert->name }}
                        </p>
                        <p class="text-sm text-gray-500">
                            Passed: {{ $cert->date_passed->format('d M Y') }}
                        </p>
                    </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">No certifications found.</p>
            @endif
        </div>

        <!-- References -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">References</h2>
            @if($user->references->count() > 0)
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($user->references as $ref)
                    <li class="py-3">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $ref->name }}
                        </p>
                        <p class="text-sm text-gray-500">{{ $ref->email }}</p>
                        <p class="text-sm text-gray-500">{{ $ref->phone }}</p>
                    </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">No references found.</p>
            @endif
        </div>
    </div>

    <!-- Recent Shifts -->
    <div class="mt-6">
        <h2 class="text-xl font-semibold mb-4">Recent Shifts</h2>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Location
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($user->shifts->take(5) as $shift)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            {{ $shift->start_datetime->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            {{ $shift->location }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $shift->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($shift->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                            No shifts found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
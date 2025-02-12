<x-admin-layout>
    <x-slot name="header">
        <x-container>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Users Management
                </h2>
            </div>
        </x-container>
    </x-slot>

    <!-- Search and Filters -->
    <div class="py-12">
        <x-container>
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.users.index') }}" method="GET" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Search -->
                            <div class="col-span-2">
                                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Search</label>
                                <input type="text" 
                                    name="search" 
                                    id="search" 
                                    value="{{ request('search') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Search by name, email, or phone...">
                            </div>

                            <!-- Job Role Filter -->
                            <div>
                                <label for="job_role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Job Role</label>
                                <select name="job_role" 
                                        id="job_role"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">All Roles</option>
                                    <option value="Registered Nurse" {{ request('job_role') == 'Registered Nurse' ? 'selected' : '' }}>
                                        Registered Nurse
                                    </option>
                                    <option value="Healthcare Assistant" {{ request('job_role') == 'Healthcare Assistant' ? 'selected' : '' }}>
                                        Healthcare Assistant
                                    </option>
                                    <option value="Support Worker" {{ request('job_role') == 'Support Worker' ? 'selected' : '' }}>
                                        Support Worker
                                    </option>
                                    <option value="Senior Care Assistant" {{ request('job_role') == 'Senior Care Assistant' ? 'selected' : '' }}>
                                        Senior Care Assistant
                                    </option>
                                </select>
                            </div>

                            <!-- Verification Status -->
                            <div>
                                <label for="verification_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Verification Status</label>
                                <select name="verification_status" 
                                        id="verification_status"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">All Status</option>
                                    <option value="verified" {{ request('verification_status') == 'verified' ? 'selected' : '' }}>
                                        Verified
                                    </option>
                                    <option value="unverified" {{ request('verification_status') == 'unverified' ? 'selected' : '' }}>
                                        Unverified
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                Apply Filters
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </x-container>
    </div>

    <!-- Users List -->
    <x-container>
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden mb-8">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Name
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Contact
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Role
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($user->profile_photo)
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . $user->profile_photo) }}" alt="">
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $user->first_name }} {{ $user->last_name }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $user->username }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-100">{{ $user->email }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->mobile_number }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $user->job_role }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->email_verified_at)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Verified
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Unverified
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                No users found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="p-4">
                {{ $users->links() }}
            </div>
        </div>
    </x-container>
</x-admin-layout>
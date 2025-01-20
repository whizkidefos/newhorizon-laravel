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
                                    <option value="registered_nurse" {{ request('job_role') == 'registered_nurse' ? 'selected' : '' }}>
                                        Registered Nurse
                                    </option>
                                    <option value="healthcare_assistant" {{ request('job_role') == 'healthcare_assistant' ? 'selected' : '' }}>
                                        Healthcare Assistant
                                    </option>
                                    <option value="support_worker" {{ request('job_role') == 'support_worker' ? 'selected' : '' }}>
                                        Support Worker
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
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <!-- Table headers... -->
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($users as $user)
                        <tr>
                            <!-- User data... -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-container>

    <!-- Pagination -->
    <x-container>
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </x-container>
</x-admin-layout>
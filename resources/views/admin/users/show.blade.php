<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                User Details
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('admin.users.edit', $user) }}" 
                   class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Edit User
                </a>
                <button onclick="openExportModal()" 
                        class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                    Export Profile
                </button>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6">
        <!-- Personal Information -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Personal Information</h3>
            
            <div class="flex items-center mb-6">
                @if($user->profile_photo)
                    <img src="{{ Storage::url($user->profile_photo) }}" 
                         alt="{{ $user->full_name }}" 
                         class="h-20 w-20 rounded-full object-cover">
                @else
                    <div class="h-20 w-20 rounded-full bg-blue-600 flex items-center justify-center text-white text-xl font-semibold">
                        {{ substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1) }}
                    </div>
                @endif
                <div class="ml-4">
                    <h4 class="text-xl font-medium text-gray-900 dark:text-white">
                        {{ $user->full_name }}
                    </h4>
                    <p class="text-gray-500 dark:text-gray-400">{{ $user->job_role }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        @if($user->email_verified_at)
                            <span class="text-green-600">✓ Email verified</span>
                        @else
                            <span class="text-red-600">✗ Email not verified</span>
                        @endif
                    </p>
                </div>
            </div>

            <dl class="grid grid-cols-1 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Mobile Number</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->mobile_number }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Date of Birth</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->date_of_birth?->format('d M Y') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Gender</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ ucfirst($user->gender) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">National Insurance Number</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->national_insurance_number }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nationality</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->nationality }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Right to Work in UK</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                        @if($user->right_to_work_uk)
                            <span class="text-green-600">✓ Yes</span>
                        @else
                            <span class="text-red-600">✗ No</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Enhanced DBS</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                        @if($user->has_enhanced_dbs)
                            <span class="text-green-600">✓ Yes</span>
                        @else
                            <span class="text-red-600">✗ No</span>
                        @endif
                    </dd>
                </div>
                @if($user->brp_number)
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">BRP Number</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->brp_number }}</dd>
                </div>
                @endif
            </dl>
        </div>

        <!-- Documents & Certifications -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Documents & Certifications</h3>
            
            <div class="space-y-4">
                @foreach($user->documents as $document)
                    <div class="border dark:border-gray-700 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $document->type }}
                                </h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Uploaded: {{ $document->created_at->format('d M Y') }}
                                </p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ Storage::url($document->file_path) }}" 
                                   target="_blank"
                                   class="text-blue-600 hover:text-blue-500">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Recent Activity</h3>
            
            <div class="flow-root">
                <ul class="-mb-8">
                    @forelse($user->activities as $activity)
                        <li>
                            <div class="relative pb-8">
                                @if(!$loop->last)
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                @endif
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-gray-400 flex items-center justify-center ring-8 ring-white">
                                            <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500">{{ $activity->description }}</p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            <time datetime="{{ $activity->created_at }}">{{ $activity->created_at->diffForHumans() }}</time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="text-gray-500 text-sm">No recent activity</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Recent Shifts -->
    <div class="mt-6 p-6">
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Recent Shifts</h3>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700">
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
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($user->shifts as $shift)
                            <tr>
                                <!-- Shift details -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Additional Details -->
    <div class="mt-6 p-6">
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Additional Details</h3>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700">
                <!-- Profile Details -->
                @if($user->profileDetail)
                <div class="px-4 py-5 sm:px-6">
                    <h4 class="text-md font-medium text-gray-900 dark:text-white mb-4">Address Information</h4>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Address</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $user->profileDetail->address_line_1 }}
                                @if($user->profileDetail->address_line_2)
                                    <br>{{ $user->profileDetail->address_line_2 }}
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">City</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->profileDetail->city }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Postcode</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->profileDetail->postcode }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Country</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->profileDetail->country }}</dd>
                        </div>
                    </dl>
                </div>
                @endif

                <!-- Bank Details -->
                @if($user->bankDetail)
                <div class="px-4 py-5 sm:px-6 border-t border-gray-200 dark:border-gray-700">
                    <h4 class="text-md font-medium text-gray-900 dark:text-white mb-4">Bank Information</h4>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Account Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->bankDetail->account_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Bank Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->bankDetail->bank_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Account Number</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->bankDetail->account_number }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Sort Code</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->bankDetail->sort_code }}</dd>
                        </div>
                    </dl>
                </div>
                @endif

                <!-- Work History -->
                @if($user->workHistory->count() > 0)
                <div class="px-4 py-5 sm:px-6 border-t border-gray-200 dark:border-gray-700">
                    <h4 class="text-md font-medium text-gray-900 dark:text-white mb-4">Work History</h4>
                    <div class="space-y-4">
                        @foreach($user->workHistory as $work)
                        <div class="border dark:border-gray-700 rounded-lg p-4">
                            <h5 class="text-sm font-medium text-gray-900 dark:text-white">{{ $work->company_name }}</h5>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $work->position }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $work->start_date?->format('M Y') }} - 
                                {{ $work->end_date ? $work->end_date->format('M Y') : 'Present' }}
                            </p>
                            @if($work->description)
                            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">{{ $work->description }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Training Records -->
                @if($user->trainingRecords->count() > 0)
                <div class="px-4 py-5 sm:px-6 border-t border-gray-200 dark:border-gray-700">
                    <h4 class="text-md font-medium text-gray-900 dark:text-white mb-4">Training Records</h4>
                    <div class="space-y-4">
                        @foreach($user->trainingRecords as $training)
                        <div class="border dark:border-gray-700 rounded-lg p-4">
                            <h5 class="text-sm font-medium text-gray-900 dark:text-white">{{ $training->title }}</h5>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Provider: {{ $training->provider }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Completed: {{ $training->completion_date?->format('d M Y') }}
                            </p>
                            @if($training->expiry_date)
                            <p class="text-sm {{ $training->expiry_date->isPast() ? 'text-red-600' : 'text-gray-500' }}">
                                Expires: {{ $training->expiry_date->format('d M Y') }}
                            </p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Export Modal -->
    <div id="exportModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                    Export Profile Configuration
                </h3>
                <form id="exportForm" action="{{ route('admin.users.export', $user) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 block mb-2">
                                Sections to Include
                            </label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="sections[]" value="personal" class="rounded border-gray-300" checked>
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Personal Information</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="sections[]" value="documents" class="rounded border-gray-300" checked>
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Documents & Certifications</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="sections[]" value="address" class="rounded border-gray-300" checked>
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Address Information</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="sections[]" value="bank" class="rounded border-gray-300">
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Bank Details</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="sections[]" value="work" class="rounded border-gray-300" checked>
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Work History</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="sections[]" value="training" class="rounded border-gray-300" checked>
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Training Records</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 block mb-2">
                                Date Range
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm text-gray-600 dark:text-gray-400">From</label>
                                    <input type="date" name="date_from" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                <div>
                                    <label class="text-sm text-gray-600 dark:text-gray-400">To</label>
                                    <input type="date" name="date_to" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-4">
                        <button type="button" onclick="closeExportModal()" 
                                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Download PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function openExportModal() {
            document.getElementById('exportModal').classList.remove('hidden');
        }

        function closeExportModal() {
            document.getElementById('exportModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('exportModal');
            const modalContent = modal.querySelector('.relative');
            if (event.target === modal) {
                closeExportModal();
            }
        });

        // Handle form submission
        document.getElementById('exportForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const formData = new FormData(form);
            
            // Show loading state
            const submitButton = form.querySelector('button[type="submit"]');
            const originalText = submitButton.innerText;
            submitButton.disabled = true;
            submitButton.innerText = 'Generating...';

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Export failed');
                return response.blob();
            })
            .then(blob => {
                // Create download link
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `user-profile-${new Date().getTime()}.pdf`;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                
                // Close modal
                closeExportModal();
            })
            .catch(error => {
                console.error('Export error:', error);
                alert('Failed to generate export. Please try again.');
            })
            .finally(() => {
                // Reset button state
                submitButton.disabled = false;
                submitButton.innerText = originalText;
            });
        });
    </script>
    @endpush
</x-admin-layout>
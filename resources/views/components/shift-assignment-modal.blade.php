<div x-data="shiftAssignment({{ $shift->id }})"
     x-show="open"
     @open-shift-assignment-modal.window="open = true"
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
        </div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                    Assign Shift
                </h3>

                <!-- Staff List -->
                <div class="mt-4 max-h-96 overflow-y-auto">
                    <div class="space-y-4">
                        <template x-for="staff in availableStaff" :key="staff.id">
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex items-center">
                                    <img :src="staff.profile_photo_url" 
                                         :alt="staff.name"
                                         class="h-10 w-10 rounded-full object-cover">
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white" 
                                           x-text="staff.name"></p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400" 
                                           x-text="staff.job_role"></p>
                                    </div>
                                </div>
                                <button @click="assignShift(staff.id)"
                                        class="bg-blue-600 text-white px-3 py-1 rounded-md hover:bg-blue-700">
                                    Assign
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="mt-5 sm:mt-6">
                <button @click="open = false"
                        class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function shiftAssignment(shiftId) {
    return {
        open: false,
        availableStaff: [],
        loading: false,

        async init() {
            await this.loadAvailableStaff();
        },

        async loadAvailableStaff() {
            try {
                const response = await axios.get(`/api/shifts/${shiftId}/available-staff`);
                this.availableStaff = response.data;
            } catch (error) {
                console.error('Error loading available staff:', error);
            }
        },

        async assignShift(userId) {
            try {
                this.loading = true;
                await axios.post(`/api/shifts/${shiftId}/assign`, {
                    user_id: userId
                });
                
                this.open = false;
                window.location.reload();
            } catch (error) {
                console.error('Error assigning shift:', error);
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
@endpush
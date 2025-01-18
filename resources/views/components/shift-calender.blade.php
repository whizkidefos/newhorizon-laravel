<div x-data="shiftCalendar()"
     x-init="initialize"
     class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
    
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Shift Schedule</h3>
        <div class="flex space-x-2">
            <x-button @click="previousWeek" variant="outline" size="sm">
                Previous
            </x-button>
            <x-button @click="nextWeek" variant="outline" size="sm">
                Next
            </x-button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr>
                    <template x-for="day in weekDays" :key="day">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider"
                            x-text="formatDate(day)">
                        </th>
                    </template>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                <tr>
                    <template x-for="day in weekDays" :key="day">
                        <td class="px-6 py-4">
                            <template x-for="shift in getShiftsForDay(day)" :key="shift.id">
                                <div class="mb-2 p-2 rounded-lg"
                                     :class="getShiftStatusColor(shift.status)">
                                    <p class="font-medium" x-text="shift.location"></p>
                                    <p class="text-sm" x-text="formatTime(shift.start_datetime)"></p>
                                </div>
                            </template>
                        </td>
                    </template>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        function shiftCalendar() {
            return {
                weekDays: [],
                shifts: [],
                currentDate: new Date(),

                initialize() {
                    this.calculateWeekDays();
                    this.fetchShifts();
                },

                calculateWeekDays() {
                    this.weekDays = [...Array(7)].map((_, i) => {
                        const date = new Date(this.currentDate);
                        date.setDate(date.getDate() - date.getDay() + i);
                        return date;
                    });
                },

                async fetchShifts() {
                    // Fetch shifts for the current week
                    const response = await fetch('/api/shifts/week?' + new URLSearchParams({
                        start_date: this.weekDays[0].toISOString(),
                        end_date: this.weekDays[6].toISOString()
                    }));
                    this.shifts = await response.json();
                },

                formatDate(date) {
                    return new Date(date).toLocaleDateString('en-GB', { 
                        weekday: 'short', 
                        day: 'numeric' 
                    });
                },

                formatTime(datetime) {
                    return new Date(datetime).toLocaleTimeString('en-GB', { 
                        hour: '2-digit', 
                        minute: '2-digit' 
                    });
                },

                getShiftsForDay(date) {
                    return this.shifts.filter(shift => {
                        const shiftDate = new Date(shift.start_datetime);
                        return shiftDate.toDateString() === date.toDateString();
                    });
                },

                getShiftStatusColor(status) {
                    const colors = {
                        open: 'bg-yellow-100 text-yellow-800',
                        assigned: 'bg-blue-100 text-blue-800',
                        completed: 'bg-green-100 text-green-800'
                    };
                    return colors[status] || 'bg-gray-100 text-gray-800';
                },

                previousWeek() {
                    this.currentDate.setDate(this.currentDate.getDate() - 7);
                    this.calculateWeekDays();
                    this.fetchShifts();
                },

                nextWeek() {
                    this.currentDate.setDate(this.currentDate.getDate() + 7);
                    this.calculateWeekDays();
                    this.fetchShifts();
                }
            }
        }
    </script>
</div>
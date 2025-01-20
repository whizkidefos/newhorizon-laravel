<div x-data="{ open: false, notifications: [] }" 
     @notification-received.window="notifications.unshift($event.detail)"
     class="relative">
    <!-- Notification Bell -->
    <button @click="open = !open" 
            class="relative p-1 rounded-full text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
        <span class="sr-only">View notifications</span>
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        
        <!-- Notification Badge -->
        <span x-show="unreadCount > 0"
              x-text="unreadCount"
              class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
        </span>
    </button>

    <!-- Notification Panel -->
    <div x-show="open"
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 w-96 mt-2 origin-top-right bg-white dark:bg-gray-800 rounded-md shadow-lg ring-1 ring-black ring-opacity-5">
        
        <div class="p-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    Notifications
                </h3>
                <button @click="markAllAsRead"
                        class="text-sm text-blue-600 hover:text-blue-500">
                    Mark all as read
                </button>
            </div>

            <div class="space-y-4 max-h-96 overflow-y-auto">
                <template x-if="notifications.length === 0">
                    <div class="text-center py-8">
                        <p class="text-gray-500 dark:text-gray-400">
                            No notifications
                        </p>
                    </div>
                </template>

                <template x-for="notification in notifications" :key="notification.id">
                    <div :class="{ 'bg-blue-50 dark:bg-blue-900': !notification.read_at }"
                         class="p-4 rounded-lg">
                        <div class="flex items-start">
                            <!-- Icon based on notification type -->
                            <div class="flex-shrink-0" x-html="getNotificationIcon(notification.type)"></div>
                            
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-gray-900 dark:text-white" 
                                   x-text="notification.message"></p>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400" 
                                   x-text="formatTime(notification.created_at)"></p>
                            </div>

                            <button @click="markAsRead(notification.id)"
                                    x-show="!notification.read_at"
                                    class="ml-4 text-gray-400 hover:text-gray-500">
                                <span class="sr-only">Mark as read</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <div class="mt-4 border-t border-gray-200 dark:border-gray-700 pt-4">
                <a href="{{ route('notifications.index') }}"
                   class="block text-center text-sm text-blue-600 hover:text-blue-500">
                    View all notifications
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function notificationCenter() {
        return {
            unreadCount: {{ auth()->user()->unreadNotifications->count() }},
            
            markAsRead(id) {
                axios.post(`/notifications/${id}/mark-as-read`)
                    .then(() => {
                        this.notifications = this.notifications.map(n => {
                            if (n.id === id) n.read_at = new Date();
                            return n;
                        });
                        this.updateUnreadCount();
                    });
            },

            markAllAsRead() {
                axios.post('/notifications/mark-all-as-read')
                    .then(() => {
                        this.notifications = this.notifications.map(n => {
                            n.read_at = new Date();
                            return n;
                        });
                        this.unreadCount = 0;
                    });
            },

            formatTime(timestamp) {
                return dayjs(timestamp).fromNow();
            },

            getNotificationIcon(type) {
                const icons = {
                    shift_assigned: `<svg class="h-6 w-6 text-blue-500" ... ></svg>`,
                    shift_reminder: `<svg class="h-6 w-6 text-yellow-500" ... ></svg>`,
                    shift_cancelled: `<svg class="h-6 w-6 text-red-500" ... ></svg>`,
                    default: `<svg class="h-6 w-6 text-gray-500" ... ></svg>`
                };
                return icons[type] || icons.default;
            },

            updateUnreadCount() {
                this.unreadCount = this.notifications.filter(n => !n.read_at).length;
            }
        }
    }
</script>
@endpush
<div x-data="notificationsManager()"
     x-init="initializeNotifications"
     @notification-received.window="addNotification($event.detail)"
     class="fixed right-0 top-0 mt-16 mr-4 z-50 w-96">
    
    <template x-for="notification in notifications" :key="notification.id">
        <div x-show="notification.show"
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="mb-4">
            <x-notification :type="notification.type" :message="notification.message" />
        </div>
    </template>

    <script>
        function notificationsManager() {
            return {
                notifications: [],
                initializeNotifications() {
                    Echo.private(`notifications.${userId}`)
                        .listen('NewNotification', (e) => {
                            this.addNotification({
                                message: e.message,
                                type: e.type
                            });
                        });
                },
                addNotification(notification) {
                    const id = Date.now();
                    this.notifications.push({
                        id,
                        message: notification.message,
                        type: notification.type,
                        show: true
                    });

                    setTimeout(() => {
                        this.removeNotification(id);
                    }, 5000);
                },
                removeNotification(id) {
                    const index = this.notifications.findIndex(n => n.id === id);
                    if (index > -1) {
                        this.notifications[index].show = false;
                        setTimeout(() => {
                            this.notifications = this.notifications.filter(n => n.id !== id);
                        }, 300);
                    }
                }
            }
        }
    </script>
</div>
import { reactive } from 'vue';
import useResumableTimer from "@/Composables/Timer/useTimer.js";
import eventSystems from "@/Events/EventSystems.js";

export default reactive({
    notifications: [],

    add(notification) {
        if (notification.key && this.find(notification.key)) {
            return;
        }

        notification.key = notification.key ?? Symbol();

        const { resume, pause, progress } = useResumableTimer(() => {
            this.remove(notification.key)
        }, notification.duration);

        this.notifications.unshift({
            ...notification,
            resume,
            pause,
            progress
        });

        // Emit the event
        if (notification?.options?.events?.length > 0) {
            notification.options.events.forEach(event => {
                eventSystems.emit(event?.name, event.data);
            });
        }

    },
    remove(key) {
        this.notifications = this.notifications.filter(notification => {
            return notification.key !== key;
        });
    },
    removeAll() {
        this.notifications = [];
    },
    find(key) {
        return this.notifications.find(notification => {
            return notification.key === key;
        });
    }
})

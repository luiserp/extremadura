<template>

    <TransitionGroup
        tag="ul"
        class="fixed top-4 right-4 z-[60] w-full max-w-sm space-y-4"
        enter-from-class="translate-x-full opacity-0"
        enter-active-class="duration-300 ease-out"
        leave-active-class="duration-300 ease-in absolute"
        leave-to-class="translate-x-full opacity-0"
        move-class="transition-all duration-300 ease-in-out"
    >
        <li
            v-for="(notification, index) in notifications.notifications"
            :key="notification.key"
            class="w-full"
        >
            <Notification
                :notification="notification"
                @close="notifications.remove(notification.key)"
            />
        </li>
    </TransitionGroup>

</template>

<script setup>
import notifications from "@/Composables/Notifications/useNotifications.js";
import {computed, onBeforeUnmount, onMounted} from "vue";
import Notification from "./Notification.vue";
import { router, usePage } from "@inertiajs/vue3";

const page = usePage();
const userId = computed(() => {
    return page.props.auth?.user?.id;
});

// Flash Messages
const remove = router.on("finish", () => {
    if (page.props.flash.notifications) {
        for (const notificaiton of page.props.flash.notifications) {
            notifications.add(notificaiton);
        }
    }
});

onMounted(() => {

    // Real time notifications
    window.Echo.private('App.Models.User.' + userId.value)
        .subscribed(() => {
            console.log('Subscribed to private channel');
        })
        .error((error) => {
            if (error.reason && error.reason["code"] == 40102) {
                location.reload()
            }
        })
        .notification((notification) => {
            notifications.add(notification);
        });
});

onBeforeUnmount(() => {
    window.Echo.leaveChannel('private:App.Models.User.' + userId.value);
    remove();
});

</script>

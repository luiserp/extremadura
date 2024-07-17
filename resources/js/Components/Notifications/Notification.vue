<template>
    <div
        class="bg-white rounded-md shadow-md"
        @mouseenter="notification?.pause"
        @mouseleave="notification?.resume"
    >
        <div class="p-4 flex items-start">
            <div class="flex-shrink-0">
                <component
                    :is="statusComponent"
                    :class="status"
                    aria-hidden="true"
                />
            </div>
            <div class="ml-3 w-0 flex-1 pt-0.5">
                <p class="text-sm font-medium text-gray-900">
                    {{ notification.message }}
                </p>
                <span
                    v-if="notification.link"
                    @click="goToLink"
                    class="mt-1 text-sm rigth-0 text-indigo-500 cursor-pointer hover:underline"
                >
                    {{ notification?.link?.name ?? "Click aquí." }}
                </span>
            </div>
            <div class="ml-4 flex-shrink-0 flex">
                <button
                    type="button"
                    @click="emit('close')"
                    class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    <span class="sr-only">Cerrar</span>
                    <XMarkIcon class="h-5 w-5" aria-hidden="true" />
                </button>
            </div>
        </div>

        <div
            class="w-full h-[2px]"
        >
            <div
                :class="[
                    'bg-indigo-600 h-[2px] rounded-md transition-all duration-[50ms] ease-in dark:bg-indigo-500',
                ]"
                :style="`width: ${notification?.progress.value}%`"
            >
            </div>
        </div>
    </div>
</template>

<script setup>
import {
CheckCircleIcon,
ExclamationCircleIcon,
ExclamationTriangleIcon,
XCircleIcon,
XMarkIcon,
} from "@heroicons/vue/24/outline";
import { computed, watch } from "vue";

const props = defineProps({
    notification: {
        type: Object,
    },
});

const emit = defineEmits(["close"]);

const statusComponent = computed(() => {
    if (props.notification) {
        switch (props.notification.type) {
            case "success":
                return CheckCircleIcon;
            case "error":
                return XCircleIcon;
            case "warning":
                return ExclamationTriangleIcon;
            case "danger":
                return XCircleIcon;
            case "info":
                return ExclamationCircleIcon;
            default:
                return CheckCircleIcon;
        }
    }
    return CheckCircleIcon;
});

const status = computed(() => {
    if (props.notification && props.notification.type === "success") {
        return "h-6 w-6 text-green-400";
    }
    if (props.notification && props.notification.type === "warning") {
        return "h-6 w-6 text-yellow-400";
    }
    if (props.notification && props.notification.type === "info") {
        return "h-6 w-6 text-blue-800";
    }
    return "h-6 w-6 text-red-400";
});

const goToLink = () => {
    emit("close");

    if (typeof props.notification?.link === "object") {
        router.visit(props.notification?.link?.route);
    } else {
        router.visit(props.notification.link);
    }
};

watch(
    () => props.notification,
    (notification) => {
        if (notification?.link?.reload) {
            router.reload();
        }
    }
, { immediate: true });
</script>

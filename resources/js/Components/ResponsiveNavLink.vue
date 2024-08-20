<script setup lang="ts">
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    href?: string;
    active?: boolean;
}>();

const classes = computed(() =>
    props.active
        ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-gray-400 bg-gray-200 text-gray-600 text-start text-base font-medium transition duration-150 ease-in-out'
        : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium transition duration-150 ease-in-out'
);
</script>

<template>
    <component :is="href ? Link : 'button'" :href="href" :class="classes">
        <slot />
    </component  >
</template>

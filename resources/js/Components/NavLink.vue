<script setup lang="ts">
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    href?: string;
    active?: boolean;
}>();

const classes = computed(() =>
    props.active
        ? 'block w-full border-gray-400 bg-gray-200 text-gray-600 text-start text-base font-medium transition duration-150 ease-in-out hover:text-gray-800'
        : 'block w-full border-transparent text-start text-gray-600 text-base font-medium transition duration-150 ease-in-out hover:text-gray-800'
);
</script>

<template>
    <component :is="href ? Link : 'button'" :href="href" :class="classes" class="whitespace-nowrap">
        <slot />
    </component>
</template>


<style scoped>
a {
    display: inline-block;
    text-decoration: none;
    font-family: sans-serif;
}

a:after {
    display: block;
    content: '';
    width: inherit;
    border-bottom: solid 3px #4b5563;
    transform: scaleX(0);
    transition: transform 250ms ease-in-out;
}

a:hover:after {
    transform: scaleX(1);
}

a.from-left:after {
    transform-origin: left;
}

a.from-right:after {
    transform-origin: right;
}
</style>

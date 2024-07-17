<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
    href?: string;
}>();

</script>

<template>
    <component :is="href ? Link : 'button'" :href="href"
        class="link block w-full px-4 py-2 text-start text-sm leading-5 ocus:outline-none transition duration-150 ease-in-out">
        <slot />
    </component>
</template>


<style scoped>

.link {
    background-color: var(--p-content-background);
    border-color: var(--p-border-color);
    color: var(--p-content-color);
}

.link:hover {
    background-color: var(--p-content-hover-background);
}

</style>

<template>
    <div class="container block mx-auto max-w-screen-2xl py-4 border my-4 bg-white p-6 rounded-lg shadow-sm">
        <div class="mx-auto px-2 sm:px-6 lg:px-8">
            <slot />
        </div>
    </div>
</template>

<script setup>

</script>

<style scoped>
    .container {
        background-color: var(--p-layout-container-background);
        border-color: var(--p-border-color);
    }
</style>

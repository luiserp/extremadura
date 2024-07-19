<template>
    <div class="container block mx-auto max-w-screen-2xl rounded-xl py-4 border mt-4">
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

<template>
    <Button @click="reloadPage" id="reload-button" type="button" severity="secondary" outlined>
        <ArrowPathIcon class="h-6 w-6" :class="{ 'animate-spin': reloading }" />
    </Button>
</template>

<script setup>
import { ArrowPathIcon } from '@heroicons/vue/20/solid';
import Button from 'primevue/button';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

// Reload
const reloading = ref(false);
const reloadPage = () => {
    reloading.value = true;
    router.reload({
        onSuccess: () => {
            setTimeout(() => {
                reloading.value = false;
            }, 1000);
        }
    });
}
</script>

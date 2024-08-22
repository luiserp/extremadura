<script setup>
import Container from "@/Components/Container/Container.vue";
import DialogWrapper from "@/Components/DialogWrapper/DialogWrapper.vue";
import Notifications from "@/Components/Notifications/Notifications.vue";
import { Head } from "@inertiajs/vue3";
import Navbar from "@/Layouts/App/partials/Navbar.vue";
import Footer from "@/Layouts/App/partials/Footer.vue";

defineProps({
    title: String,
    homePath: {
        type: String,
        default: "welcome",
    },
});

</script>

<template>
    <div>
        <Head>
            <title>{{ title }}</title>
        </Head>

        <div class="min-h-screen main-section" :style="{ backgroundColor: 'var(--p-layout-background)' }">
            <!-- Navigation -->
            <Navbar
                :homePath="homePath"
            />

            <!-- Page Heading -->
            <header v-if="$slots.header" class="px-2">
                <Container>
                    <slot name="header" />
                </Container>
            </header>

            <!-- Page Content -->
            <main class="px-2">
                <slot />
            </main>

            <!-- Footer -->
            <Footer />
        </div>

        <!-- Global Components -->
        <Notifications />
        <DialogWrapper />
    </div>
</template>

<style scoped>
.main-section {
    display: grid;
    grid-template-rows: auto auto 1fr auto;
}
</style>

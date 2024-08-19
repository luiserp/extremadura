<script setup lang="ts">
import Container from "@/Components/Container/Container.vue";
import AppLayout from '@/Layouts/App/AppLayout.vue';
import { Link } from "@inertiajs/vue3";
import { trans } from 'laravel-vue-i18n';
import Button from "primevue/button";
import { route } from 'ziggy-js'

</script>

<template>

    <AppLayout :title="trans('book.books')">

        <Container>


            <div class="flex gap-2 flex-col">
                <div class="p-4 border rounded-lg">
                    <h2 class="font-semibold">Devtools</h2>
                    <p>
                        This is a collection of tools that are useful for development.
                    </p>
                </div>
                <div class="p-4 border rounded-lg">
                    <h3 class="font-semibold">Notifications</h3>
                    <p>
                        Notifications are a way to inform users of events that have occurred in the system.
                    </p>

                    <div class="mt-2">
                        <Link
                            :href="route('devtools.broadcasting-test')"
                        >
                            <Button>
                                Show Notification
                            </Button>
                        </Link>
                    </div>

                </div>
            </div>





        </Container>

    </AppLayout>
</template>

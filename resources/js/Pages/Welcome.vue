<script setup lang="ts">
import Card from '@/Components/Card/Card.vue';
import AppLayout from '@/Layouts/App/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
import Button from 'primevue/button';
import { route } from 'ziggy-js'

defineProps({
    books: {
        type: Object as () => App.Dtos.BookDto[],
        required: true
    }
});
</script>

<template>

    <AppLayout :title="trans('book.books')">

        <!-- Main Content -->
        <div class="container mx-auto p-6">
            <!-- Intro Section -->
            <section class="text-center my-12">
                <h2 class="text-3xl font-semibold mb-4">{{ trans('welcome.welcome_title') }}</h2>
                <p class="text-lg mb-8">{{ trans('welcome.welcome_description') }}</p>
                <Link
                    :href="route('books.index')"
                >
                    <Button>
                        {{ trans('welcome.welcome_cta') }}
                    </Button>
                </Link>
            </section>

            <!-- Featured Books Section -->
            <section id="catalogo" class="my-12">
                <h3 class="text-2xl font-semibold mb-6">{{ trans('welcome.welcome_books_title') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <Card v-for="book in books"
                        :title="book.title"
                        :description="book.description"
                        :link="route('books.detail', { id: book.id })"
                    />
                </div>
            </section>
        </div>
    </AppLayout>
</template>

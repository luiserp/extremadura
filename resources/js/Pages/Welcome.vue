<script setup lang="ts">
import Card from '@/Components/Card/Card.vue';
import Container from '@/Components/Container/Container.vue';
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
        <!-- Intro Section -->
        <Container>
            <section class="text-center my-12">
                <h2 class="text-3xl font-semibold mb-4">{{ trans('welcome.welcome_title') }}</h2>
                <p class="text-lg mb-8">{{ trans('welcome.welcome_description') }}</p>
                <Link :href="route('books.index')">
                <Button>
                    {{ trans('welcome.welcome_cta') }}
                </Button>
                </Link>
            </section>
        </Container>

        <Container>
            <!-- Featured Books Section -->
            <section id="catalogo">
                <h3 class="text-2xl font-semibold my-8 text-center">{{ trans('welcome.welcome_books_title') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <Card v-for="book in books" :title="book.title" :description="book.description"
                        :link="route('books.detail', { id: book.id })" />
                </div>
            </section>
        </Container>
    </AppLayout>
</template>

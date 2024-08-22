<script setup lang="ts">
import Card from '@/Components/Card/Card.vue';
import Container from '@/Components/Container/Container.vue';
import PieGraph from '@/Components/Graphs/PieGraph.vue';
import StackedBar from '@/Components/Graphs/StackedBar.vue';
import AppLayout from '@/Layouts/App/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
import Button from 'primevue/button';
import { route } from 'ziggy-js'

defineProps({
    books: {
        type: Object as () => App.Dtos.BookDto[],
        required: true
    },
    bookCitiesStats: {
        type: Object as () => App.Dtos.BookStatsDto,
        required: true
    },
    bookAuthorsStats: {
        type: Object as () => App.Dtos.BookStatsDto,
        required: true
    },
    bookCategoriesStats: {
        type: Object as () => App.Dtos.BookStatsDto,
        required: true
    },
    citiesCategoriesStats: {
        type: Object as () => App.Dtos.BookStatsDto,
        required: true
    },
});
</script>

<template>
    <AppLayout :title="trans('book.books')">
        <!-- Intro Section -->
        <Container>
            <section class="text-center">
                <h2 class="text-3xl font-semibold mb-4">{{ trans('welcome.welcome_title') }}</h2>
                <p class="text-lg mb-8">{{ trans('welcome.welcome_description') }}</p>
                <Link :href="route('books.index')">
                <Button>
                    {{ trans('welcome.welcome_cta') }}
                </Button>
                </Link>
            </section>
        </Container>

        <!-- Featured Books Section -->
        <Container>
            <section id="catalogo">
                <h3 class="text-2xl font-semibold mb-12 mt-4 text-center underline">
                    {{ trans('welcome.welcome_books_title') }}
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <Card v-for="book in books" :title="book.title" :description="book.description"
                        :link="route('books.detail', { id: book.id })" />
                </div>
            </section>
        </Container>

        <!-- Stats Section -->
        <Container>
            <section id="estadisticas">
                <h3 class="text-2xl font-semibold mb-12 mt-4 text-center underline">
                    {{ trans('book.stats') }}
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <PieGraph :title="trans('book.books_per_city') + ':'" :labels="bookCitiesStats.labels"
                        :data="bookCitiesStats.data" />
                    <PieGraph :title="trans('book.books_per_author') + ':'" :labels="bookAuthorsStats.labels"
                        :data="bookAuthorsStats.data" />
                    <PieGraph :title="trans('book.books_per_category') + ':'" :labels="bookCategoriesStats.labels"
                        :data="bookCategoriesStats.data" />
                </div>

                <div class="grid grid-cols-1 mt-16">
                    <StackedBar :title="trans('book.books_per_city_per_category') + ':'"
                        :labels="citiesCategoriesStats.labels" :data="citiesCategoriesStats.data" />
                </div>
            </section>
        </Container>
    </AppLayout>
</template>

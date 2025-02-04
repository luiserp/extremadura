<template>
    <Container v-if="statsLoaded">
        <section id="estadisticas" class="relative">
            <div class="absolute right-0" title="reload">
                <Button @click="getBookStats" id="reload-button" type="button" severity="secondary" outlined>
                    <ArrowPathIcon class="h-6 w-6" :class="{ 'animate-spin': reloading }" />
                </Button>
            </div>
            <h3 class="text-2xl font-semibold mb-12 mt-4 text-center underline">
                {{ trans('book.stats') }}
            </h3>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
                <PieGraph v-if="bookCitiesStats" :title="trans('book.books_per_city') + ':'"
                    :labels="bookCitiesStats.labels" :data="bookCitiesStats.data" />
                <PieGraph v-if="bookAuthorsStats" :title="trans('book.books_per_author') + ':'"
                    :labels="bookAuthorsStats.labels" :data="bookAuthorsStats.data" />
                <PieGraph v-if="bookCategoriesStats" :title="trans('book.books_per_category') + ':'"
                    :labels="bookCategoriesStats.labels" :data="bookCategoriesStats.data" />
            </div>

            <div class="grid grid-cols-1 mt-16">
                <StackedBar v-if="citiesCategoriesStats" :title="trans('book.books_per_city_per_category') + ':'"
                    :labels="citiesCategoriesStats.labels" :data="citiesCategoriesStats.data" />
            </div>
        </section>
    </Container>
</template>

<script setup lang="ts">
import Container from '@/Components/Container/Container.vue';
import PieGraph from '@/Components/Graphs/PieGraph.vue';
import StackedBar from '@/Components/Graphs/StackedBar.vue';
import { ArrowPathIcon } from '@heroicons/vue/24/outline';
import axios from 'axios';
import { trans } from 'laravel-vue-i18n';
import Button from 'primevue/button';
import { computed, onMounted, ref } from 'vue';

const bookCitiesStats = ref < App.Dtos.BookStatsDto | null > (null);
const bookAuthorsStats = ref < App.Dtos.BookStatsDto | null > (null);
const bookCategoriesStats = ref < App.Dtos.BookStatsDto | null > (null);
const citiesCategoriesStats = ref<App.Dtos.BookStatsDto | null>(null);

const reloading = ref(false);

onMounted(() => {
    getBookStats();
});

const statsLoaded = computed(() => {
    return bookCitiesStats.value !== null && bookAuthorsStats.value !== null &&
        bookCategoriesStats.value !== null && citiesCategoriesStats.value !== null;
});

const getBookStats = async () => {
    reloading.value = true;
    try {
        const response = await axios.get(route('api.stats.book'));
        bookCitiesStats.value = response.data.bookCitiesStats;
        bookAuthorsStats.value = response.data.bookAuthorsStats;
        bookCategoriesStats.value = response.data.bookCategoriesStats;
        citiesCategoriesStats.value = response.data.citiesCategoriesStats;
    } catch (error) {
        console.error(error);
    } finally {
        setTimeout(() => {
            reloading.value = false;
        }, 1000);
    }
};

</script>

<style lang="scss" scoped>

</style>

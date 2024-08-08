<script setup lang="ts">
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import AppLayout from '@/Layouts/App/AppLayout.vue';
import { capitalizeWords } from '@/Services/Utils';
import { Paginator as TypePaginator } from '@/types/paginator';
import { ArrowDownOnSquareIcon, ArrowLeftIcon, CalculatorIcon, Cog6ToothIcon, HeartIcon, ListBulletIcon } from '@heroicons/vue/24/outline';
import { Link, router } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
import Column from 'primevue/column';
import DataTable from 'primevue/datatable';
import Paginator from 'primevue/paginator';
import { computed, ref, watch } from 'vue';
import Container from "@/Components/Container/Container.vue";
import { useBook } from '@/Composables/Book/Book';
import BookFilter from './Partials/BookFilter.vue';
import ToggleSwitch from 'primevue/toggleswitch';
import { App } from '@/types/app';
import Button from 'primevue/button';

const props = defineProps({
    books: {
        type: Object as () => TypePaginator<App.Dtos.BookDto>,
        required: true
    },
    filters: {
        type: Object as () => App.Dtos.BookFilterDto,
        required: true
    },
    categories: {
        type: Array as () => App.Dtos.CategoryDto[],
        required: true
    },
});

const booksData = computed(() => {
    return props.books.data
});

const onPageChange = (event: { page: number, rows: number }) => {
    router.get(route('books.index', { page: event.page + 1, per_page: event.rows, ...props.filters }), {}, { preserveScroll: true });
}

const currentPage = computed(() => {
    return props.books.per_page * (props.books.current_page - 1);
});

const { showBook, editBook, deleteBook, calculateEmbedding, calculateSentiment } = useBook();

const selected = ref<App.Dtos.BookDto | null>(null);
watch(() => selected.value, (value) => {
    if (value) {
        showBook(value.id);
    }
});

const setStatus = (book: App.Dtos.BookDto) => {
    router.get(route('books.set-active', { id: book.id }), {}, { preserveScroll: true });
}

</script>

<template>

    <AppLayout :title="trans('book.books')">
        <template #header>
            <div class="flex justify-between items-center gap-2">
                <div>

                </div>
                <div class="flex gap-2">
                    <a :href="route('books.export')">
                        <Button severity="secondary" outlined>
                            {{ $t('common.export') }}
                            <ArrowDownOnSquareIcon class="h-6 w-6" />
                        </Button>
                    </a>
                    <Dropdown width="66">
                        <template #trigger>
                            <Button
                                class="flex justify-center items-center gap-2 text-sm transition border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300">
                                {{ $t('common.actions') }}
                                <CalculatorIcon class="h-6 w-6" />
                            </Button>
                        </template>
                        <template #content>
                            <DropdownLink @click="calculateEmbedding">
                                <div class="flex gap-2">
                                    {{ $t("book.calculate_embeddings") }}
                                </div>
                            </DropdownLink>
                            <DropdownLink @click="calculateSentiment">
                                <div class="flex gap-2">
                                    {{ $t("book.calculate_sentiment") }}
                                </div>
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </div>
        </template>

        <Container>
            <BookFilter :filters="props.filters" :books="books" :categories="categories" />
        </Container>

        <Container>
            <DataTable :value="booksData" tableStyle="min-width: 50rem" rowHover @row-dblclick="selected = $event.data"
                :rowClass="() => 'cursor-pointer select-none'">
                <Column :header="trans('book.title')">
                    <template #body="{ data }">
                        <div :title="data.title" class="truncate max-h-18 max-w-80">
                            {{ data.title }}

                            <div class="flex gap-2">
                                <p>{{ trans('book.authors') + ': ' }}</p>
                                <div class="flex gap-2">
                                    <p v-for="author, index in data.authors" class="font-light text-sm">
                                        {{ author.name + (index < data.authors.length - 1 ? ',' : '' ) }} </p>
                                </div>
                            </div>
                            <div class="flex gap-2 mt-2">
                                <span :title="trans('book.has_sentiment')" v-if="data.has_sentiment">
                                    <HeartIcon class="h-5 w-5" style="color: var(--p-text-color)" />
                                </span>
                                <span :title="trans('book.has_embeddings')" v-if="data.has_embeddings">
                                    <ListBulletIcon class="h-5 w-5" style="color: var(--p-text-color)" />
                                </span>
                            </div>
                        </div>
                    </template>
                </Column>
                <Column :header="trans('book.category')">
                    <template #body="{ data }">
                        <div>{{ capitalizeWords(data.category.name) }}</div>
                    </template>
                </Column>
                <Column :header="trans('book.year')">
                    <template #body="{ data }">
                        <div class="flex flex-col whitespace-nowrap">
                            <span class="font-light">{{ trans('book.catalog') + ': ' + data.catalog }}</span>
                            <span class="font-light">{{ trans('book.year') + ': ' + data.year }}</span>
                        </div>
                    </template>
                </Column>
                <Column field="editorial" :header="trans('book.editorial')"></Column>
                <Column field="city" :header="trans('book.city')"></Column>
                <Column :header="trans('book.description')">
                    <template #body="{ data }">
                        <div class="truncate max-h-14 max-w-80">
                            {{ data.description }}
                        </div>
                    </template>
                </Column>
                <Column :header="trans('common.status')">
                    <template #body="{ data }">
                        <div class="flex justify-center">
                            <ToggleSwitch v-model="data.active" @change="setStatus(data)" />
                        </div>
                    </template>
                </Column>
                <Column :header="trans('common.actions')">
                    <template #body="{ data }">
                        <div class="flex justify-center">
                            <Dropdown>
                                <template #trigger>
                                    <button
                                        class="flex text-sm transition border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300">
                                        <Cog6ToothIcon class="h-6 w-6" style="color: var(--p-text-color)" />
                                    </button>
                                </template>
                                <template #content>
                                    <DropdownLink @click="showBook(data.id)">
                                        <div class="flex gap-2">
                                            {{ $t("common.show") }}
                                        </div>
                                    </DropdownLink>
                                    <DropdownLink @click="editBook(data.id)">
                                        <div class="flex gap-2">
                                            {{ $t("common.edit") }}
                                        </div>
                                    </DropdownLink>
                                    <DropdownLink @click="deleteBook(data.id)">
                                        <div class="flex gap-2">
                                            {{ $t("common.delete") }}
                                        </div>
                                    </DropdownLink>
                                    <DropdownLink @click="calculateEmbedding(data)">
                                        <div class="flex gap-2">
                                            {{ $t("book.calculate_embeddings") }}
                                        </div>
                                    </DropdownLink>
                                    <DropdownLink @click="calculateSentiment(data)">
                                        <div class="flex gap-2">
                                            {{ $t("book.calculate_sentiment") }}
                                        </div>
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </template>
                </Column>
            </DataTable>

            <div class="mt-6">
                <Paginator :rows="books.per_page" :totalRecords="books.total"
                    :rowsPerPageOptions="[5, 10, 15, 20, 50, 100]" :first="currentPage" @page="onPageChange">
                </Paginator>
            </div>
        </Container>

    </AppLayout>
</template>

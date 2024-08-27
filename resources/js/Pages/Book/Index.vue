<script setup lang="ts">
import Container from "@/Components/Container/Container.vue";
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { useBook } from '@/Composables/Book/Book';
import AppLayout from '@/Layouts/App/AppLayout.vue';
import { capitalizeWords } from '@/Services/Utils';
import { Paginator as TypePaginator } from '@/types/paginator';
import { ArrowDownOnSquareIcon, ArrowPathIcon, ArrowUpOnSquareIcon, CalculatorIcon, Cog6ToothIcon, DocumentTextIcon, HeartIcon, ListBulletIcon, TrashIcon } from '@heroicons/vue/24/outline';
import { router } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
import Button from 'primevue/button';
import Column from 'primevue/column';
import DataTable from 'primevue/datatable';
import Paginator from 'primevue/paginator';
import ToggleSwitch from 'primevue/toggleswitch';
import { computed, ref, watch } from 'vue';
import BookFilter from './Partials/BookFilter.vue';
import { route } from 'ziggy-js'
import { can } from "@/Utils/roles";
import ReloadButton from "@/Components/Buttons/ReloadButton.vue";

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

const { showBook, editBook, deleteBook, deleteAllBooks, calculateEmbedding, calculateSentiment, calculateStats, createDescription, generateImage } = useBook();

const selected = ref<App.Dtos.BookDto | null>(null);
watch(() => selected.value, (value) => {
    if (value) {
        showBook(value.id);
    }
});

const setStatus = (book: App.Dtos.BookDto) => {
    router.get(route('books.set-active', { id: book.id }), {}, { preserveScroll: true });
}

// Import
const inputImport = ref<HTMLInputElement | null>(null);
function importButton() {
    inputImport.value?.click();
}

function resetFileInput(event: any) {
    event.target.value = "";
}

function importFile(event: any) {
    const formData = new FormData();
    for (let i = 0; i < event.target.files.length; i++) {
        formData.append("files[]", event.target.files[i]);
    }
    router.post(route('books.import'), formData);
}


</script>

<template>

    <AppLayout :title="trans('book.books')">
        <template #header>
            <div class="flex justify-between items-center gap-2">
                <div>

                </div>
                <div class="flex gap-2 flex-wrap">
                    <!-- Reload -->
                    <ReloadButton />
                    <!-- Import -->
                    <form v-if="can('add books')">
                        <input id="file-customer" name="file-customer" type="file" class="sr-only"
                            @click="resetFileInput($event)" @change="importFile($event)" ref="inputImport" multiple />
                        <Button id="import-button" type="button" severity="secondary" outlined @click="importButton">
                            {{ $t('common.import') }}
                            <ArrowDownOnSquareIcon class="h-6 w-6" />
                        </Button>
                    </form>

                    <!-- Export -->
                    <a v-if="can('download books')" :href="route('books.export')">
                        <Button severity="secondary" outlined>
                            {{ $t('common.export') }}
                            <ArrowDownOnSquareIcon class="h-6 w-6" />
                        </Button>
                    </a>
                    <!-- Actions -->
                    <Dropdown v-if="can('edit books')" width="66">
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
                            <DropdownLink @click="calculateStats">
                                <div class="flex gap-2">
                                    {{ $t("book.calculate_stats") }}
                                </div>
                            </DropdownLink>
                        </template>
                    </Dropdown>
                    <!-- Delete -->
                    <Button severity="danger" v-if="can('delete books')" @click="deleteAllBooks">
                        {{ $t('common.delete') }}
                        <TrashIcon class="h-6 w-6" />
                    </Button>
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
                        <div :title="data.title" class="truncate max-h-18 max-w-64">
                            {{ data.title }}

                            <div class="flex gap-2 items-baseline">
                                <p>{{ trans('book.authors') + ': ' }}</p>
                                <div class="flex gap-2">
                                    <p v-for="author, index in data.authors" class="font-light text-sm">
                                        {{ author.name + (index < data.authors.length - 1 ? ',' : '') }} </p>
                                </div>
                            </div>
                            <div class="flex gap-2 mt-2">
                                <span :title="trans('book.has_sentiment')" v-if="data.has_sentiment">
                                    <HeartIcon class="h-5 w-5" style="color: var(--p-text-color)" />
                                </span>
                                <span :title="trans('book.has_embeddings')" v-if="data.has_embeddings">
                                    <ListBulletIcon class="h-5 w-5" style="color: var(--p-text-color)" />
                                </span>
                                <span :title="trans('book.has_description')" v-if="data.has_description">
                                    <DocumentTextIcon class="h-5 w-5" style="color: var(--p-text-color)" />
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
                <Column v-if="can('edit books')" :header="trans('common.status')">
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
                                    <DropdownLink v-if="can('edit books')" @click="editBook(data.id)">
                                        <div class="flex gap-2">
                                            {{ $t("common.edit") }}
                                        </div>
                                    </DropdownLink>
                                    <DropdownLink v-if="can('delete books')" @click="deleteBook(data.id)">
                                        <div class="flex gap-2">
                                            {{ $t("common.delete") }}
                                        </div>
                                    </DropdownLink>
                                    <DropdownLink v-if="can('edit books')" @click="calculateEmbedding(data)">
                                        <div class="flex gap-2">
                                            {{ $t("book.calculate_embeddings") }}
                                        </div>
                                    </DropdownLink>
                                    <DropdownLink v-if="can('edit books')" @click="calculateSentiment(data)">
                                        <div class="flex gap-2">
                                            {{ $t("book.calculate_sentiment") }}
                                        </div>
                                    </DropdownLink>
                                    <DropdownLink v-if="can('edit books')" @click="createDescription(data)">
                                        <div class="flex gap-2">
                                            {{ $t("book.book_create_prompt") }}
                                        </div>
                                    </DropdownLink>
                                    <DropdownLink v-if="can('edit books')" @click="generateImage(data)">
                                        <div class="flex gap-2">
                                            {{ $t("book.book_generate_image") }}
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

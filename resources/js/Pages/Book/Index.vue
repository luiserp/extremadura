<script setup lang="ts">
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import AppLayout from '@/Layouts/App/AppLayout.vue';
import { capitalizeWords } from '@/Services/Utils';
import { App } from '@/types/generated';
import { Paginator as TypePaginator } from '@/types/paginator';
import { Cog6ToothIcon } from '@heroicons/vue/24/outline';
import { Head, router } from '@inertiajs/vue3';
import Column from 'primevue/column';
import DataTable from 'primevue/datatable';
import Paginator from 'primevue/paginator';
import { computed } from 'vue';

const props = defineProps({
    books: {
        type: Object as () => TypePaginator<App.Dtos.BookDto>,
        required: true
    },
});

const booksData = computed(() => {
    return props.books.data
});

const onPageChange = (event: { page: number, rows: number }) => {
    router.get(route('books.index', { page: event.page + 1, per_page: event.rows }), {}, { preserveScroll: true });
}

const currentPage = computed(() => {
    return props.books.per_page * (props.books.current_page - 1);
});

console.log(props.books);

</script>

<template>

    <Head title="Dashboard" />

    <AppLayout>

        <div class="py-6">
            <div class="block mx-auto max-w-screen-2xl rounded-xl px-8 py-4 shadow-sm border text-sm"
                :style="{ backgroundColor: 'var(--p-layout-container-background)', borderColor: 'var(--p-border-color)' }">
                <DataTable :value="booksData" tableStyle="min-width: 50rem">
                    <Column header="Title">
                        <template #body="{ data }">
                            <div :title="data.title" class="truncate max-h-14 max-w-80">
                                {{ data.title }}
                            </div>
                        </template>
                    </Column>
                    <Column header="Category">
                        <template #body="{ data }">
                            <div>{{ capitalizeWords(data.category.name) }}</div>
                        </template>
                    </Column>
                    <Column header="Year">
                        <template #body="{ data }">
                            <div class="flex flex-col whitespace-nowrap">
                                <span class="font-light">Catalog: {{ data.catalog }}</span>
                                <span class="font-light">Year: {{ data.year }}</span>
                            </div>
                        </template>
                    </Column>
                    <Column field="editorial.name" header="Editorial"></Column>
                    <Column field="city.name" header="City"></Column>
                    <Column header="Description">
                        <template #body="{ data }">
                            <div class="truncate max-h-14 max-w-80">
                                {{ data.description }}
                            </div>
                        </template>
                    </Column>
                    <Column header="Actions">
                        <template #body="{ data }">
                            <div class="flex justify-center">
                                <Dropdown width="24">
                                    <template #trigger>
                                        <button
                                            class="flex text-sm transition border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300">
                                            <Cog6ToothIcon class="h-6 w-6" style="color: var(--p-text-color)" />
                                        </button>
                                    </template>
                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')">
                                            <div class="flex gap-2">
                                                {{ $t("common.show") }}
                                            </div>
                                        </DropdownLink>
                                        <DropdownLink :href="route('profile.edit')">
                                            <div class="flex gap-2">
                                                {{ $t("common.edit") }}
                                            </div>
                                        </DropdownLink>
                                        <DropdownLink>
                                            <div class="flex gap-2">
                                                {{ $t("common.delete") }}
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
            </div>
        </div>

    </AppLayout>
</template>

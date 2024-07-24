<template>
    <Filter :filters="filters" :filtersOptions="filtersOptions" :route="route('books.index')"
        :searchPlaceholder="trans('filters.search')" withDatePicker withYearPicker />
</template>

<script setup lang="ts">
import Filter from "@/Components/Filters/Filter.vue";
import { computed } from "vue";
import { Paginator as TypePaginator } from '@/types/paginator';
import { capitalizeWords } from "@/Services/Utils";
import { trans } from "laravel-vue-i18n";
import { App } from '@/types/app';

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

type FilterOption = {
    value: string | number | boolean;
    label: string;
    checked: boolean;
};

const filtersOptions = computed(() => {

    const filters = [];

    // Categories
    const categories = {
        id: "categories",
        name: trans('book.category'),
        multiple: true,
        options: [] as FilterOption[],
    };

    props.categories.forEach((category) => {
        categories.options.push({ value: category.id, label: capitalizeWords(category.name), checked: false });
    });

    filters.push(categories);

    // Status
    const status = {
        id: "status",
        name: trans('filters.status'),
        multiple: false,
        options: [
            { value: 1, label: trans('filters.active'), checked: false },
            { value: 0, label: trans('filters.inactive'), checked: false },
        ] as FilterOption[],
    };

    filters.push(status);

    return filters;
});

</script>

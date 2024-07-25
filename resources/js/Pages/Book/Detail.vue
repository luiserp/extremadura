<script setup lang="ts">
import Container from '@/Components/Container/Container.vue';
import { useBook } from '@/Composables/Book/Book';
import AppLayout from '@/Layouts/App/AppLayout.vue';
import { capitalizeWords } from '@/Services/Utils';
import { App } from '@/types/app';
import { ArrowLeftIcon } from '@heroicons/vue/24/outline';
import { Link } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
import Button from 'primevue/button';
import Panel from 'primevue/panel';
import { computed } from 'vue';

const props = defineProps({
    book: {
        type: Object as () => App.Dtos.BookDto,
        required: true
    },
});

const bookData = computed(() => {
    return props.book
});

const { showBook, editBook, deleteBook } = useBook();

</script>

<template>

    <AppLayout :title="trans('book.books') + ' - ' + bookData.title">
        <template #header>
            <div class="flex justify-between items-center gap-2">
                <div>
                    <Link :href="route('books.index')">
                        <Button>
                            <ArrowLeftIcon class="h-5 w-5" />
                        </Button>
                    </Link>
                </div>
                <div class="flex gap-2">
                    <Button @click="editBook(bookData.id)">
                        {{ trans('common.edit') }}
                    </Button>
                    <Button @click="deleteBook(bookData.id)" severity="danger">
                        {{ trans('common.delete') }}
                    </Button>
                </div>
            </div>
        </template>

        <Container>
            <div class="flex justify-between flex-wrap">
                <div class="flex-auto space-y-2">
                    <h1 class="text-xl font-bold">{{ bookData.title }}</h1>
                    <div class="flex gap-2 flex-col">
                        <p v-for="author in bookData.authors">
                            {{ author.name }}
                        </p>
                    </div>
                </div>
                <div class="flex-auto space-y-2 text-sm">
                    <h1 class="text-xl font-bold">{{ trans('common.metadata') }}</h1>
                    <p>
                        {{ trans('book.year') + ': ' + bookData.year }}
                    </p>
                    <p>
                        {{ trans('book.catalog') + ': ' + bookData.catalog }}
                    </p>
                    <p>
                        {{ trans('book.editorial') + ': ' + bookData.editorial }}
                    </p>
                    <p>
                        {{ trans('book.city') + ': ' + bookData.city }}
                    </p>
                    <p>
                        {{ trans('book.category') + ': ' + capitalizeWords(bookData.category?.name ?? '') }}
                    </p>
                </div>
            </div>
            <div class="mt-4 space-y-2">
                <Panel :header="trans('book.description')" toggleable>
                    <p class="text-base">
                        {{ bookData.description }}
                    </p>
                </Panel>
            </div>
        </Container>

    </AppLayout>
</template>

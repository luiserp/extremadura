<script setup lang="ts">
import PrevAndNextButtons from '@/Components/Books/PrevAndNextButtons.vue';
import Container from '@/Components/Container/Container.vue';
import { useBook } from '@/Composables/Book/Book';
import AppLayout from '@/Layouts/App/AppLayout.vue';
import { capitalizeWords } from '@/Services/Utils';
import { can } from '@/Utils/roles';
import { ArrowLeftIcon } from '@heroicons/vue/24/outline';
import { Link } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
import Button from 'primevue/button';
import Textarea from 'primevue/textarea';
import ToggleSwitch from 'primevue/toggleswitch';
import { computed } from 'vue';
import { route } from 'ziggy-js';

const props = defineProps({
    book: {
        type: Object as () => App.Dtos.BookDto,
        required: true
    },
});

const bookData = computed(() => {
    return props.book
});

const bookDescription = computed(() => {
    return bookData.value.bookDescription?.description ?? '';
});

console.log(bookData.value);


const { showBook, editBook, checkBook, deleteBook, setStatus } = useBook();

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
                <div v-if="can('edit books')" class="flex gap-2">
                    <Button @click="checkBook(bookData)" outlined>
                        {{ trans('common.check') }}
                    </Button>
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
            <div class="flex justify-between">
                <div class="flex justify-between flex-wrap grow">
                    <div class="flex-auto space-y-2">
                        <h1 class="text-xl font-bold max-w-[30vw] break-words">{{ bookData.title }}</h1>
                        <div class="flex gap-2 flex-col">
                            <h2>{{ trans('book.authors') }}</h2>
                            <p v-for="author in bookData.authors">
                                {{ author.name }}
                            </p>
                        </div>
                    </div>
                    <div class="flex-auto space-y-2">
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
                <div>
                    <!-- Back and Next Book Button -->
                    <PrevAndNextButtons :bookData="bookData" />

                    <div class="flex justify-center mt-4 gap-2">
                        <label for="active">{{ trans('common.status') + ':' }}</label>
                        <ToggleSwitch v-model="bookData.active" @change="setStatus(bookData)" />
                    </div>
                </div>
            </div>

            <div class="mt-4 space-y-2">
                <h2 class="font-semibold">{{ trans('book.description') }}</h2>
                <p class="w-full" > {{ bookData.description }} </p>
            </div>
            <!-- <div class="mt-4 space-y-2">
                <h2 class="font-semibold">{{ trans('book.reference') }}</h2>
                <Textarea v-model="bookData.reference" rows="8" cols="30" class="w-full" readonly />
            </div> -->
        </Container>
        <!-- AI -->
        <!-- <Container>
            <div class="mt-4 space-y-2">
                <h2 class="font-semibold">{{ trans('book.prompt') }}</h2>
                <Textarea v-model="bookDescription" rows="8" cols="30" class="w-full" readonly />
            </div>
            <div class="mt-4 space-y-2 space-x-1">
                <h2 class="font-semibold">{{ trans('book.images') }}</h2>
                <img :src="bookData.image_urls" alt="book image" class="max-h-64 object-contain rounded" />
            </div>
        </Container> -->
    </AppLayout>
</template>

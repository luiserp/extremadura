<script setup lang="ts">
import Container from '@/Components/Container/Container.vue';
import { useBook } from '@/Composables/Book/Book';
import AppLayout from '@/Layouts/App/AppLayout.vue';
import { capitalizeWords } from '@/Services/Utils';
import { App } from '@/types/app';
import { ArrowLeftIcon, XCircleIcon } from '@heroicons/vue/24/outline';
import { Link } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
import Button from 'primevue/button';
import Panel from 'primevue/panel';
import { computed, onMounted, ref } from 'vue';
import InputText from 'primevue/inputtext';
import Select from 'primevue/select';
import Textarea from 'primevue/textarea';
import { can } from '@/Utils/roles';
import PrevAndNextButtons from '@/Components/Books/PrevAndNextButtons.vue';
import ToggleSwitch from 'primevue/toggleswitch';

const props = defineProps({
    book: {
        type: Object as () => App.Dtos.BookDto,
        required: true
    },
    categories: {
        type: Array as () => App.Dtos.CategoryDto[],
        required: true
    }
});

const bookData = computed(() => {
    return props.book
});

const { form, setForm, showBook, checkBook, editBook, deleteBook, updateBook, deleteImage, setStatus } = useBook();

const back = () => {
    showBook(bookData.value.id);
};


onMounted(() => {
    setForm(props.book);
});

const bookDescription = ref(bookData.value.bookDescription?.description ?? '');

</script>

<template>

    <AppLayout :title="trans('book.books') + ' - ' + bookData.title">
        <template #header>
            <div class="flex justify-between items-center gap-2">
                <div>
                    <Button @click="back">
                        <ArrowLeftIcon class="h-5 w-5" />
                    </Button>
                </div>
                <div v-if="can('edit books')" class="flex gap-2">
                    <Button @click="checkBook(bookData)" outlined>
                        {{ trans('common.check') }}
                    </Button>
                    <Button @click="back()" severity="secondary" outlined>
                        {{ trans('common.cancel') }}
                    </Button>
                    <Button @click="updateBook(bookData.id)" severity="success">
                        {{ trans('common.save') }}
                    </Button>
                </div>
            </div>
        </template>

        <Container>
            <div class="flex justify-between">

                <div class="flex justify-between flex-wrap grow">
                    <div class="flex-auto space-y-2">
                        <div class="flex gap-2 items-center text-xl">
                            <InputText id="year" type="text" v-model="form.title" />
                        </div>
                        <div class="flex gap-2 flex-col">
                            <template v-for="author, idx in form.authors">
                                <h2>{{ trans('book.authors') }}</h2>
                                <div class="flex gap-2 items-center">
                                    <InputText id="author" type="text" v-model="form.authors[idx].name" size="small" />
                                </div>
                            </template>
                        </div>
                    </div>
                    <div class="flex-auto space-y-2">
                        <h1 class="text-xl font-bold">{{ trans('common.metadata') }}</h1>
                        <div class="flex gap-2 items-center">
                            <label for="year">{{ trans('book.year') }}</label>
                            <InputText id="year" type="text" v-model="form.year" size="small" />
                        </div>
                        <div class="flex gap-2 items-center">
                            <label for="catalog">{{ trans('book.catalog') }}</label>
                            <InputText id="catalog" type="text" v-model="form.catalog" size="small" />
                        </div>
                        <div class="flex gap-2 items-center">
                            <label for="editorial">{{ trans('book.editorial') }}</label>
                            <InputText id="editorial" type="text" v-model="form.editorial" size="small" />
                        </div>
                        <div class="flex gap-2 items-center">
                            <label for="city">{{ trans('book.city') }}</label>
                            <InputText id="city" type="text" v-model="form.city" size="small" />
                        </div>
                        <div class="flex gap-2 items-center">
                            <label for="category">{{ trans('book.category') }}</label>
                            <Select id="category" v-model="form.category" :options="categories" optionLabel="name" />
                        </div>
                    </div>
                </div>

                <div>
                    <!-- Back and Next Book Button -->
                    <PrevAndNextButtons :bookData="bookData" routeName="books.edit" />

                    <div class="flex justify-center mt-4 gap-2">
                        <label for="active">{{ trans('common.status') + ':'}}</label>
                        <ToggleSwitch v-model="bookData.active" @change="setStatus(bookData)" />
                    </div>
                </div>
            </div>

            <div class="mt-4 space-y-2">
                <h2 class="ml-4 font-semibold">{{ trans('book.description') }}</h2>
                <Textarea v-model="form.description" rows="8" cols="30" class="w-full" />
            </div>
            <div class="mt-4 space-y-2">
                <h2 class="ml-4 font-semibold">{{ trans('book.reference') }}</h2>
                <Textarea v-model="form.reference" rows="8" cols="30" class="w-full" />
            </div>
        </Container>

        <!-- AI -->
        <Container>
            <div class="mt-4 space-y-2">
                <h2 class="font-semibold">{{ trans('book.prompt') }}</h2>
                <Textarea v-model="bookDescription" rows="8" cols="30" class="w-full" />
            </div>
            <div class="">
                <h2 class="font-semibold">{{ trans('book.images') }}</h2>
                <div v-for="image in bookData.image_urls" class="group relative inline-block max-w-64">
                    <div @click="deleteImage(image.id)"
                        class="absolute w-full backdrop-blur-sm h-10 bg-white/30 borde group-hover:opacity-100 opacity-0 transition">
                        <span class="absolute right-1 top-1 cursor-pointer">
                            <XCircleIcon class="h-5 w-5 text-gray-700 hover:text-gray-800" />
                        </span>
                    </div>
                    <img :src="image.url" alt="book image" class="object-cover" />
                </div>
            </div>
        </Container>

    </AppLayout>
</template>

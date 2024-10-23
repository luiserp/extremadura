<template>
    <div class="flex-auto space-y-2">
        <div class="flex gap-2">
            <Link :href="previousLink">
            <Button outlined :disabled="previousLink === ''">
                <ArrowLeftIcon class="h-5 w-5" />
            </Button>
            </Link>
            <Link :href="nextLink">
            <Button outlined :disabled="nextLink === ''">
                <ArrowRightIcon class="h-5 w-5" />
            </Button>
            </Link>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ArrowLeftIcon, ArrowRightIcon } from '@heroicons/vue/24/outline';
import { Link } from '@inertiajs/vue3';
import Button from 'primevue/button';
import { computed } from 'vue';
import { route } from 'ziggy-js';

const props = defineProps({
    bookData: {
        type: Object as () => App.Dtos.BookDto,
        required: true,
    },
    routeName: {
        type: String,
        required: true,
        default: 'books.detail',
    },
});

const nextLink = computed(() => {
    if (!props.bookData.nextBook?.id) {
        return '';
    }

    return route(props.routeName, { id: props.bookData.nextBook?.id });
});

const previousLink = computed(() => {
    if (!props.bookData.previousBook?.id) {
        return '';
    }

    return route(props.routeName, { id: props.bookData.previousBook?.id });
});

</script>

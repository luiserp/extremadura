<template>
    <div class="bg-white p-6 rounded-lg shadow-md border">
        <img v-if="image" :src="image" class="w-full max-h-64 object-cover mb-4 rounded">
        <h4 class="text-xl font-semibold mb-2">{{ title }}</h4>
        <p class="text-gray-700 max-h-32 whitespace-normal line-clamp-5 py-2">{{ description }}</p>
        <a v-if="link" :href="link" class="text-blue-800 hover:underline mt-4 inline-block">
            {{ trans('common.see_more') }}
        </a>
    </div>
</template>

<script setup>
import { trans } from 'laravel-vue-i18n';


const props = defineProps({
    title: {
        type: String,
        required: true
    },
    description: {
        type: String,
        required: true
    },
    image_urls: {
        type: Array,
        required: false
    },
    link: {
        type: String,
        required: true
    }
});

const image = props.image_urls ? props.image_urls[0] : null;
</script>

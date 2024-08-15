<template>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <img v-if="image" src="https://via.placeholder.com/150" alt="Libro 3" class="w-full max-h-64 object-cover mb-4 rounded">
        <h4 class="text-xl font-semibold mb-2">{{ title }}</h4>
        <p class="text-gray-700 max-h-32 whitespace-normal line-clamp-5 py-2">{{ description }}</p>
        <a v-if="link" :href="link" class="text-blue-800 hover:underline mt-4 inline-block">Más información</a>
    </div>
</template>

<script setup>

defineProps({
    title: {
        type: String,
        required: true
    },
    description: {
        type: String,
        required: true
    },
    image: {
        type: String|undefined,
        required: false
    },
    link: {
        type: String,
        required: true
    }
});

</script>

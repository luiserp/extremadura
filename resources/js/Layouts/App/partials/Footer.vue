<template>
    <!-- HTML -->
    <footer class="bg-white border-t shadow-sm">
        <div class="grid grid-cols-1 sm:grid-cols-3 py-8 px-28">
            <div>
                <p class="text-lg font-semibold mb-2">
                    {{ trans('footer.explore') }}
                </p>
                <ul class="space-y-2">
                    <li>
                        <Link :href="route('welcome')" class="hover:underline">{{ trans('nav.home') }}</Link>
                    </li>
                    <li>
                        <Link :href="route('books.index')" class="hover:underline">{{ trans('book.books') }}</Link>
                    </li>
                    <li><a href="#about" class="hover:underline">About</a></li>
                </ul>
            </div>
        </div>
        <div class="flex justify-center pb-4">
            <!-- <img src="path-to-your-logo.png" alt="Logo" class="h-12 mb-2"> -->
            <p class="text-lg font-serif">
                {{ trans('footer.slogan') }}
            </p>
        </div>
    </footer>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';

</script>

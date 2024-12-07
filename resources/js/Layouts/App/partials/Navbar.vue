<template>
    <nav class="border-b shadow-sm" :style="{
        backgroundColor: 'var(--p-layout-navigation-background)',
        borderColor: 'var(--p-border-color)',
    }">
        <!-- Primary Navigation Menu -->
        <div class="px-8 shadow-sm">
            <div class="flex justify-between h-16">
                <div class="flex items-center align-bottom gap-6">
                    <!-- Logo -->
                    <NavLink :href="route(homePath)">
                        <HomeIcon class="h-6 w-6" />
                    </NavLink>
                    <div class="flex mt-2">
                        <NavLink :href="route('books.index')">
                            {{ trans('book.books') }}
                        </NavLink>
                    </div>
                </div>
                <div class="hidden space-x-0 sm:flex sm:items-center sm:ms-6">
                    <!-- Navigation Links sm:flex -->
                    <div class="hidden mx-2 space-x-2 sm:-my-px sm:ms-10 sm:flex">

                        <!-- <button @click="toggleColorScheme">
                                    <component :is="colorScheme === 'light' ? MoonIcon : SunIcon" class="h-6 w-6"
                                        style="color: var(--p-text-color)" />
                                </button> -->

                        <!-- Lang -->
                        <Dropdown>
                            <template #trigger>
                                <button class="flex text-sm transition border-2 border-transparent rounded-full">
                                    <LanguageIcon class="h-6 w-6 " />
                                </button>
                            </template>

                            <template #content>
                                <DropdownLink @click="changeLanguage('en')">
                                    English
                                </DropdownLink>
                                <DropdownLink @click="changeLanguage('es')">
                                    Español
                                </DropdownLink>
                            </template>
                        </Dropdown>

                    </div>
                    <!-- Profile Settings Dropdown -->
                    <div v-if="$page.props.auth.user" class="relative">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <button
                                    class="flex text-sm transition border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300">
                                    <p>{{ $page.props.auth.user.name }}</p>
                                </button>
                            </template>

                            <template #content>
                                <!-- <DropdownLink :href="route('profile.edit')">
                                            {{ $t("nav.profile") }}
                                        </DropdownLink> -->

                                <!-- Authentication -->
                                <form @submit.prevent="logout">
                                    <DropdownLink as="button">
                                        {{ $t("nav.logout") }}
                                    </DropdownLink>
                                </form>
                            </template>
                        </Dropdown>
                    </div>
                    <div v-else-if="canLogin" class="sm:top-0 sm:right-0 p-6 text-end flex gap-4">
                        <NavLink v-if="$page.props.auth.user" :href="route('books.index')" class="font-semibold">
                            {{ trans('nav.home') }}
                        </NavLink>

                        <template v-else>
                            <NavLink :href="route('login')">
                                {{ trans('nav.login') }}
                            </NavLink>

                            <NavLink v-if="canRegister" :href="route('register')">
                                {{ trans('nav.register') }}
                            </NavLink>
                        </template>
                    </div>
                </div>

                <!-- Hamburger -->
                <div class="flex items-center -me-2 sm:hidden">
                    <button
                        class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500"
                        @click="
                            showingNavigationDropdown =
                            !showingNavigationDropdown
                            ">
                        <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{
                                hidden: showingNavigationDropdown,
                                'inline-flex':
                                    !showingNavigationDropdown,
                            }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{
                                hidden: !showingNavigationDropdown,
                                'inline-flex':
                                    showingNavigationDropdown,
                            }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{
            block: showingNavigationDropdown,
            hidden: !showingNavigationDropdown,
        }" class="sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <ResponsiveNavLink :href="route(homePath)" :active="route().current(homePath)">
                    {{ trans('nav.home') }}
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('login')" :active="route().current(homePath)">
                    {{ trans('nav.login') }}
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('register')" :active="route().current(homePath)">
                    {{ trans('nav.register') }}
                </ResponsiveNavLink>
            </div>

            <!-- Responsive Settings Options -->
            <div v-if="$page.props.auth.user" class="pt-4 pb-1 border-t border-gray-200">
                <div class="flex items-center px-4">
                    <div>
                        <div class="text-base font-medium text-gray-800 capitalize">
                            {{ $page.props.auth.user.name }}
                        </div>
                        <div class="text-sm font-medium text-gray-500">
                            {{ $page.props.auth.user.email }}
                        </div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <!-- <ResponsiveNavLink :href="route('profile.edit')" :active="route().current('profile.edit')">
                                {{ $t("nav.profile") }}
                            </ResponsiveNavLink> -->

                    <!-- Authentication -->
                    <form method="POST" @submit.prevent="logout">
                        <ResponsiveNavLink as="button">
                            {{ $t("nav.logout") }}
                        </ResponsiveNavLink>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { useColorScheme } from '@/Composables/ColorScheme/colorScheme';
import { useLocale } from '@/Composables/Locale/locale';
import { HomeIcon, LanguageIcon } from '@heroicons/vue/24/outline';
import { usePage } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
import { computed, ref } from 'vue';

defineProps({
    homePath: {
        type: String,
        default: 'welcome',
    },
});

const page = usePage();

const showingNavigationDropdown = ref(false);

const logout = () => {
    router.post(route("logout"));
};

const { changeLanguage } = useLocale();

const { colorScheme, toggleColorScheme } = useColorScheme();

const canLogin = computed(() => {
    return page.props.canLogin;
});

const canRegister = computed(() => {
    return page.props.canRegister;
});
</script>

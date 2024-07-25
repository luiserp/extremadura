<template>
    <div>
        <!-- Search -->
        <div class="flex content-center mt-1 rounded-md">
            <form class="flex w-full gap-2 flex-wrap xl:flex-nowrap md:ml-0" @submit.prevent="filter">
                <div v-if="searchPlaceholder != ''" class="relative w-full rounded-md">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <MagnifyingGlassIcon class="w-5 h-5 text-gray-400" aria-hidden="true" />
                    </div>
                    <input type="search" @input="(event) => search(event.target.value)" :value="props.filters.search"
                        name="search" id="search-field"
                        class="content-center block w-full pl-10 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        :placeholder="searchPlaceholder" />
                </div>
                <div v-if="withDatePicker || withMonthsPicker || withYearPicker"
                    class="w-full flex flex-wrap md:flex-nowrap gap-2">
                    <DatePicker v-if="withDatePicker"
                        input-class="content-center block w-full pl-4 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        v-model:value="filtersform.dates" :shortcuts="datePickerShorcuts" value-type="format"
                        format="YYYY-MM-DD" range :placeholder="trans('filters.dates')" @change="filterByDate"
                        @keyup.enter.native="filterByDate">
                    </DatePicker>
                    <DatePicker v-if="withMonthsPicker"
                        input-class="content-center block w-full pl-4 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        v-model:value="filtersform.month" type="month" value-type="format" format="YYYY-MM"
                        :placeholder="trans('filters.month')" @change="filterByMonth"
                        @keyup.enter.native="filterByMonth">
                    </DatePicker>
                    <DatePicker v-if="withYearPicker"
                        input-class="content-center block w-full pl-4 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        v-model:value="filtersform.year" type="year" value-type="format" format="YYYY"
                        :placeholder="trans('filters.year')" @change="filterByYear" @keyup.enter.native="filterByYear">
                    </DatePicker>
                </div>
            </form>
        </div>

        <div class="mt-1">
            <!-- Mobile filter dialog -->
            <TransitionRoot as="template" :show="open">
                <Dialog as="div" class="relative z-40 sm:hidden" @close="open = false">
                    <TransitionChild as="template" enter="transition-opacity ease-linear duration-300"
                        enter-from="opacity-0" enter-to="opacity-100"
                        leave="transition-opacity ease-linear duration-300" leave-from="opacity-100"
                        leave-to="opacity-0">
                        <div class="fixed inset-0 bg-black bg-opacity-25" />
                    </TransitionChild>

                    <div class="fixed inset-0 z-40 flex">
                        <TransitionChild as="template" enter="transition ease-in-out duration-300 transform"
                            enter-from="translate-x-full" enter-to="translate-x-0"
                            leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0"
                            leave-to="translate-x-full">
                            <DialogPanel
                                class="relative ml-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-white py-4 pb-12 shadow-xl">
                                <div class="flex items-center justify-between px-4">
                                    <h2 class="text-lg font-medium text-gray-900">
                                        Filters
                                    </h2>
                                    <button type="button"
                                        class="-mr-2 flex h-10 w-10 items-center justify-center rounded-md bg-white p-2 text-gray-400"
                                        @click="open = false">
                                        <span class="sr-only">Close menu</span>
                                        <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                                    </button>
                                </div>

                                <!-- Filters -->
                                <form class="mt-1">
                                    <template v-for="section in filtersOptionsRef" :key="section.name">
                                        <Disclosure as="div" class="border-t border-gray-200 px-4 py-6"
                                            v-slot="{ open }" v-if="!section.hidden">
                                            <h3 class="-mx-2 -my-3 flow-root">
                                                <DisclosureButton
                                                    class="flex w-full items-center justify-between bg-white px-2 py-3 text-sm text-gray-400">
                                                    <span class="font-medium text-gray-900">{{
                                                        section.name
                                                        }}</span>
                                                    <span class="ml-6 flex items-center">
                                                        <ChevronDownIcon :class="[
                                                                    open
                                                                        ? '-rotate-180'
                                                                        : 'rotate-0',
                                                                    'h-5 w-5 transform',
                                                                ]" aria-hidden="true" />
                                                    </span>
                                                </DisclosureButton>
                                            </h3>
                                            <DisclosurePanel class="pt-6">
                                                <div class="space-y-6">
                                                    <div v-for="(
                                                            option, optionIdx
                                                        ) in section.options" :key="option.value"
                                                        class="flex items-center">
                                                        <input :id="`filter-mobile-${section.id}-${optionIdx}`"
                                                            :name="`${section.id}[]`" :value="option.value
                                                                " type="checkbox" v-model="option.checked
        " @change="
        selectOption(
            section,
            option
        )
        " class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                                        <label :for="`filter-mobile-${section.id}-${optionIdx}`"
                                                            class="ml-3 text-sm text-gray-500">{{
                                                            option.label
                                                            }}</label>
                                                    </div>
                                                </div>
                                            </DisclosurePanel>
                                        </Disclosure>
                                    </template>
                                </form>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </Dialog>
            </TransitionRoot>

            <!-- Filters -->
            <section aria-labelledby="filter-heading">
                <h2 id="filter-heading" class="sr-only">Filtros</h2>

                <div v-if="filtersOptionsRef.length > 0" class="border rounded-md bg-white border-gray-300 py-4">
                    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
                        <div></div>

                        <button type="button"
                            class="inline-block text-sm font-medium text-gray-700 hover:text-gray-900 sm:hidden"
                            @click="open = true">
                            Filtros
                        </button>

                        <div class="hidden sm:block">
                            <div class="flow-root">
                                <PopoverGroup
                                    class="-mx-4 flex flex-wrap items-center gap-y-2 xl:divide-x divide-gray-200">
                                    <template v-for="(
                                            section, sectionIdx
                                        ) in filtersOptionsRef" :key="section.name">
                                        <Popover class="relative inline-block px-4 sm:py-2 xl:py-0 text-left"
                                            v-if="!section.hidden">
                                            <PopoverButton
                                                class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900">
                                                <span>{{ section.name }}</span>
                                                <span v-if="filtersCount(section) !=
                                                    0
                                                    "
                                                    class="ml-1.5 rounded bg-gray-200 px-1.5 py-0.5 text-xs font-semibold tabular-nums text-gray-700">{{
                                                    filtersCount(section)
                                                    }}</span>
                                                <ChevronDownIcon
                                                    class="-mr-1 ml-1 h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500"
                                                    aria-hidden="true" />
                                            </PopoverButton>
                                            <transition enter-active-class="transition ease-out duration-100"
                                                enter-from-class="transform opacity-0 scale-95"
                                                enter-to-class="transform opacity-100 scale-100"
                                                leave-active-class="transition ease-in duration-75"
                                                leave-from-class="transform opacity-100 scale-100"
                                                leave-to-class="transform opacity-0 scale-95">
                                                <PopoverPanel
                                                    class="absolute right-0 z-10 max-h-60 max-w-md custom-scroll overflow-y-auto mt-2 origin-top-right rounded-md bg-white p-4 shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none">
                                                    <form class="space-y-4">
                                                        <div v-for="(
                                                                option,
                                                                        optionIdx
                                                            ) in section.options" :key="option.value"
                                                            class="flex items-center select-none">
                                                            <input :id="`filter-${section.id}-${optionIdx}`"
                                                                :name="`${section.id}[]`" :value="option.value
                                                                    " type="checkbox" v-model="option.checked
        " @change="
        selectOption(
            section,
            option
        )
        " class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                                            <label :for="`filter-${section.id}-${optionIdx}`"
                                                                class="ml-3 whitespace-nowrap pr-6 text-sm cursor-pointer font-medium text-gray-900">{{
                                                                option.label
                                                                }}</label>
                                                        </div>
                                                    </form>
                                                </PopoverPanel>
                                            </transition>
                                        </Popover>
                                    </template>
                                </PopoverGroup>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active filters -->
                <transition enter-active-class="transition ease-out duration-100"
                    enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                    leave-active-class="transition ease-in duration-75"
                    leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                    <div class="bg-gray-100" v-if="activeFilters.length > 0">
                        <div class="mx-auto max-w-7xl px-4 py-2 sm:flex sm:items-center sm:px-6 lg:px-8">
                            <h3 class="text-sm font-medium text-gray-500">
                                Filtros
                                <span class="sr-only">, active</span>
                            </h3>

                            <div aria-hidden="true" class="hidden h-5 w-px bg-gray-300 sm:ml-4 sm:block" />

                            <div class="mt-2 sm:ml-4 sm:mt-0">
                                <div class="-m-1 flex flex-wrap items-center">
                                    <transition-group name="list" tag="ul">
                                        <span v-for="activeFilter in activeFilters" :key="activeFilter.value"
                                            class="m-1 inline-flex items-center rounded-full border border-gray-200 bg-white py-1.5 pl-3 pr-2 text-sm font-medium text-gray-900">
                                            <span>{{ activeFilter.label }}</span>
                                            <button type="button"
                                                class="ml-1 inline-flex h-4 w-4 flex-shrink-0 rounded-full p-1 text-gray-400 hover:bg-gray-200 hover:text-gray-500"
                                                @click="
                                                    removeFilter(
                                                        activeFilter.sectionId,
                                                        activeFilter.label
                                                    )
                                                    ">
                                                <span class="sr-only">Remove filter for
                                                    {{ activeFilter.label }}</span>
                                                <svg class="h-2 w-2" stroke="currentColor" fill="none"
                                                    viewBox="0 0 8 8">
                                                    <path stroke-linecap="round" stroke-width="1.5"
                                                        d="M1 1l6 6m0-6L1 7" />
                                                </svg>
                                            </button>
                                        </span>
                                    </transition-group>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>
            </section>
        </div>
    </div>
</template>

<script setup>
import {
    Dialog,
    DialogPanel,
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Popover,
    PopoverButton,
    PopoverGroup,
    PopoverPanel,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import {
    ChevronDownIcon,
    MagnifyingGlassIcon,
    XMarkIcon,
} from "@heroicons/vue/20/solid";
import { useForm } from "@inertiajs/vue3";
import dayjs from "dayjs";
import {pickBy} from "lodash";
import debounce from "lodash/debounce";
import {onMounted, reactive, ref, watch} from "vue";
import DatePicker from "vue-datepicker-next";
import "../../../css/datepicker.css";
import { trans } from "laravel-vue-i18n";

const props = defineProps({
    searchPlaceholder: String,
    // Route from the index of elements
    route: {
        //Can be a named route. ex 'index' or a result of route('index', { param: a })
        type: String,
        required: true,
    },
    filters: {
        type: Object,
        default: {
            search: "",
            dates: null,
        },
    }, //Active filters
    filtersOptions: {
        type: Object,
        required: true,
        default: [
            //An array of options
            {
                // Options must have:
                id: "test",
                name: "Test",
                hidden: false, // The options will be hidden and only will be showen in the filters section
                multiple: false, // can be checked multiple options
                options: [
                    // value is sent to backend(can be a string or an array, representing a range ), labes is showed in ui, chacked means if it was checked
                    {value: "1", label: "Cliente 1", checked: false},
                    {
                        value: [1, 50],
                        label: "1 a 50 documentos",
                        checked: false,
                    },
                ],
            },
        ],
    },
    sort: Object, // Active sort Option, Not implemented yet
    sortOptions: {
        // Not implemented yet
        type: Array,
        default: [
            {name: "Most Popular", href: "#", current: true},
            {name: "Best Rating", href: "#", current: false},
            {name: "Newest", href: "#", current: false},
        ],
    },
    withMonthsPicker: {
        type: Boolean,
        default: false,
    },
    withDatePicker: {
        type: Boolean,
        default: false,
    },
    withYearPicker: {
        type: Boolean,
        default: false,
    },
    datePickerShorcuts: {
        type: Array,
        default: [
            {
                text: "1990-2000",
                onClick() {
                    const start = new Date(1990, 0, 1);
                    const end = new Date(2000, 11, 31);
                    return [start, end];
                },
            },
            {
                text: "2000-2010",
                onClick() {
                    const start = new Date(2000, 0, 1);
                    const end = new Date(2010, 11, 31);
                    return [start, end];
                },
            },
            {
                text: "2010-2020",
                onClick() {
                    const start = new Date(2010, 0, 1);
                    const end = new Date(2020, 11, 31);
                    return [start, end];
                },
            },
            {
                text: "2020-2030",
                onClick() {
                    const start = new Date(2020, 0, 1);
                    const end = new Date(2030, 11, 31);
                    return [start, end];
                },
            },
        ],
    },
});
const filtersOptionsRef = ref([]);

// UI Control
onMounted(() => {
    filtersOptionsRef.value = props.filtersOptions;
    parseFiltersFromProps();

});

watch(() => props.filtersOptions, () => {
    filtersOptionsRef.value = props.filtersOptions;
    parseFiltersFromProps();
})

const open = ref(false);
const activeFilters = ref([]);


function selectOption(section, option) {
    if (!section.multiple) {
        for (let opt of section.options) {
            opt.checked = option.checked ? opt.value == option.value : false;
        }
    }

    reloadActivefilters();
}

function removeFilter(sectionId, label) {
    let section = filtersOptionsRef.value.find((item) => item.id == sectionId);
    let option = section?.options.find((item) => item.label == label);
    if (!option) {
        console.log("No option found");
        return;
    }
    option.checked = false;

    reloadActivefilters();
}

function filtersCount(section) {
    return (
        activeFilters.value.filter((item) => item.sectionId == section.id)
            .length ?? 0
    );
}

function reloadActivefilters() {
    activeFilters.value = [];
    console.log(filtersOptionsRef.value)
    filtersOptionsRef.value.forEach((filter) => {
        filter.options.forEach((option) => {
            if (option.checked) {
                console.log(option)
                activeFilters.value.push({
                    sectionId: filter.id,
                    value: option.value,
                    label: option.label,
                });
            }
        });
    });
    sortFilters();
    filter();
}

const filtersform = reactive({
    search: props.filters?.search ?? null,
    dates: props.filters?.dates ?? null,
    month: props.filters?.month ?? null,
    year: props.filters?.year ?? null,
});


// Filter process
function search(value) {
    filtersform.search = value;
    debounce(filter, 1500)();
}

function filterByDate() {
    filtersform.month = null;
    filtersform.year = null;
    if (!filtersform.dates[0]) {
        filtersform.dates = null;
    }
    filter();
}

function filterByMonth() {
    filtersform.dates = null;
    filtersform.year = null;
    if (!filtersform.month) {
        filtersform.month = null;
    }
    filter();
}

function filterByYear() {
    filtersform.dates = null;
    filtersform.month = null;
    if (!filtersform.year) {
        filtersform.year = null;
    }
    filter();
}

function filter() {
    filtersOptionsRef.value.forEach((filter) => {
        filtersform[filter.id] = activeFilters.value
            .filter((item) => item.sectionId == filter.id)
            .map((item) => item.value);
    });

    const form = useForm(pickBy(filtersform));

    let toRoute = props.route;
    if (!props.route.startsWith("http")) {
        toRoute = route(props.route);
    }

    form.get(toRoute, {
        preserveScroll: true,
        replace: true,
        preserveState: true,
    });
}

function parseFiltersFromProps() {
    if (!props.filters) return;

    activeFilters.value = [];

    for (const [key, val] of Object.entries(props.filters)) {
        const filter = filtersOptionsRef.value.find((item) => item.id == key);

        if (!filter) continue;

        if (!val) continue;

        if (isRangeOption(val)) {
            parseRangeOption(filter, val);
        } else {
            parseStringOption(filter, val);
        }
    }

    sortFilters();
}

function isRangeOption(val) {
    return Array.isArray(val[0]);
}

function parseRangeOption(filter, val) {
    let option = filter.options.find(
        (item) => item.value[0] == val[0] && item.value[1] == val[1]
    );

    if (!option) {
        return;
    }

    setActiveFilter(filter, option);
}

function parseStringOption(filter, val) {
    for (let value of val) {
        let option = filter.options.find((item) => {
            // console.log(item.value, value, item.value == value);
            return item.value == value;
        });

        if (!option) {
            console.error("No filter option for:", value, "in", filter.options);
            return;
        }

        setActiveFilter(filter, option);
    }
}

function setActiveFilter(filter, option) {
    activeFilters.value.push({
        sectionId: filter.id,
        value: option.value,
        label: option.label,
    });
    option.checked = true;
}

function sortFilters() {
    activeFilters.value.sort((a, b) => {
        return a.label > b.label ? 1 : -1;
    });
}
</script>

<style scoped>
/* Style for the scrollbar */
::-webkit-scrollbar {
    width: 5px;
    height: 5px;
}

/* Style for the scrollbar thumb */
::-webkit-scrollbar-thumb:hover {
    background-color: #acb3bb;
    border-radius: 999px;
}

/* Style for the scrollbar thumb */
::-webkit-scrollbar-thumb {
    background-color: #cbd5e0;
    border-radius: 999px;
}

/* Style for the scrollbar track */
::-webkit-scrollbar-track {
    background-color: #edf2f7;
}

.list-move, /* apply transition to moving elements */
.list-enter-active,
.list-leave-active {
    transition: all 0.5s ease;
}

.list-enter-from,
.list-leave-to {
    opacity: 0;
    transform: translateX(30px);
}

.list-leave-active {
    position: absolute;
}
</style>

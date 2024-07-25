<template>
    <TransitionRoot as="template" :show="showModal">
        <Dialog as="div" class="relative z-50" @close="closeOnEsc">
            <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0"
                enter-to="opacity-100" leave="ease-in duration-300" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-in-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel
                            class="relative overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:w-full"
                            :class="[computedSize]">
                            <div class="relative px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                                <!-- X Close Button -->
                                <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block" v-if="xcloseButtonOption">
                                    <button type="button"
                                        class="text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                        @click="xcloseButton">
                                        <span class="sr-only">Close</span>
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <!-- Content -->
                                <div class="sm:flex sm:items-start justify-center">
                                    <!-- Main Content -->
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                        <DialogTitle as="h3"
                                            class="text-lg font-semibold leading-6 text-center text-gray-900">
                                            {{ title }}
                                        </DialogTitle>
                                        <div class="mt-2 text-gray-700">
                                            <slot name="body">
                                                <h5 class="text-base font-semibold leading-6 text-center text-gray-900">
                                                    {{ subtitle }}</h5>
                                                <p class="mt-4 text-sm font-medium text-gray-500">{{ message }}</p>
                                            </slot>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Buttons -->
                            <div class="gap-4 px-4 py-3 sm:px-6 sm:flex sm:flex-row justify-center">
                                <template v-if="buttons.length > 0">
                                    <component v-for="button in buttons" :key="button.label" :is="Button"
                                        :severity="button.type == 'primary' ? 'primary' : 'secondary'" type="button"
                                        @click="confirm(button.emit)">
                                        {{ button.label }}
                                    </component>
                                </template>
                                <slot v-else name="buttons">
                                    <Button type="button" @click="confirm(true)">
                                        {{ okButton }}
                                    </Button>
                                    <Button type="button" severity="secondary" outlined @click="close()">
                                        {{ cancelButton }}
                                    </Button>
                                </slot>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot, } from "@headlessui/vue";
import { computed } from "@vue/reactivity";
import { ref, watch } from "vue";
import Button from 'primevue/button';

const props = defineProps({
    show: Boolean,
    size: {
        type: String,
        default: "md",
    },
    title: {
        type: String,
        default: "Confimación",
    },
    subtitle: {
        type: String,
        default: "Subtitulo de confimación",
    },
    message: {
        type: String,
        default: "Confimación",
    },
    okButton: {
        type: String,
        default: "Aceptar",
    },
    cancelButton: {
        type: String,
        default: "Cancelar",
    },
    buttons: {
        type: Array,
        default: () => [],
    },
    closeOnEscOption: {
        type: Boolean,
        default: true,
    },
    xcloseButtonOption: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["confirm", "close"]);

const computedSize = computed(() => {
    switch (props.size) {
        case "sm":
            return "sm:max-w-sm";
        case "md":
            return "sm:max-w-md";
        case "lg":
            return "sm:max-w-lg";
        case "xl":
            return "sm:max-w-xl";
    }
});

const showModal = ref(props.show);

watch(() => props.show, (value) => {
    showModal.value = value;
});

// Close Logic
async function closeOnEsc() {
    if (!props.closeOnEscOption) return;
    await close();
}

async function xcloseButton() {
    if (!props.xcloseButtonOption) return;
    await close();
}

async function close() {
    showModal.value = false;
    await timeout();
    emit("close", false);
}

// Confirm Logic
async function confirm(value) {
    showModal.value = false;
    await timeout();
    emit("confirm", value);
}

async function timeout(ms = 100) {
    return await new Promise((resolve) => setTimeout(resolve, ms));
}

</script>

import TaxoConfirmationModal from "@/Components/Modals/TaxoConfirmationModal.vue";
import { ref, reactive } from "vue";

let dialogId = 0;
export const dialogRefStore = reactive([]);

function getDialogId() {
    return dialogId++;
}

function deleteDialog(id) {
    const index = dialogRefStore.findIndex((dialog) => dialog.id === id);
    dialogRefStore.splice(index, 1);
}

export function useDialogs(component = TaxoConfirmationModal) {
    // Private variables
    // Work with promises and callbacks
    const ID = getDialogId();
    const resolvePromise = ref(undefined);
    const rejectPromise = ref(undefined);
    const onCancelCallback = ref(() => {});
    const onConfirmCallback = ref(() => {});

    /**
     * @template T props
     * @param {T|import("@/Interfaces/TaxoConfirmationModalInterface").TaxoConfirmationModalInterface} props
     * @returns {Promise<unknown>}
     */
    function show(props) {
        dialogRefStore.push({
            dialog: component,
            props,
            show: true,
            cancel: (data) => {
                _cancel(data);
            },
            confirm: (data) => {
                _confirm(data);
            },
        });

        return new Promise((resolve, reject) => {
            resolvePromise.value = resolve;
            rejectPromise.value = reject;
        });
    }

    const onCancel = (callback) => {
        onCancelCallback.value = callback;
    };

    const onConfirm = (callback) => {
        onConfirmCallback.value = callback;
    };

    function _confirm(data) {
        deleteDialog(ID);
        setTimeout(() => {
            onConfirmCallback.value();
            resolvePromise.value(data);
        }, 100);
    }

    function _cancel(data) {
        deleteDialog(ID);
        setTimeout(() => {
            onCancelCallback.value();
            resolvePromise.value(data);
        }, 100);
    }

    return {
        show,
        onCancel,
        onConfirm,
    };
}

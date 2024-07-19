import TaxoConfirmationModal from "@/Components/Modals/TaxoConfirmationModal.vue";
import { ref, reactive } from "vue";
import { TaxoConfirmationModalInterface } from "@/types/confirmation-modal-interface";

let dialogId = 0;
export const dialogRefStore = reactive<any>([]);

function getDialogId() {
    return dialogId++;
}

function deleteDialog(id: number) {
    const index = dialogRefStore.findIndex(
        (dialog: { id: number }) => dialog.id === id
    );
    dialogRefStore.splice(index, 1);
}

export function useDialogs(component = TaxoConfirmationModal) {
    // Private variables
    // Work with promises and callbacks
    const ID = getDialogId();
    const resolvePromise = ref<Function>(() => {});
    const rejectPromise = ref<Function>(() => {});
    const onCancelCallback = ref<Function>(() => {});
    const onConfirmCallback = ref<Function>(() => {});

    /**
     * @template T props
     * @param {TaxoConfirmationModalInterface} props
     * @returns {Promise<unknown>}
     */
    function show(props: TaxoConfirmationModalInterface) {
        dialogRefStore.push({
            dialog: component,
            props,
            show: true,
            cancel: (data: any) => {
                _cancel(data);
            },
            confirm: (data: any) => {
                _confirm(data);
            },
        });

        return new Promise((resolve, reject) => {
            resolvePromise.value = resolve;
            rejectPromise.value = reject;
        });
    }

    const onCancel = (callback: Function) => {
        onCancelCallback.value = callback;
    };

    const onConfirm = (callback: Function) => {
        onConfirmCallback.value = callback;
    };

    function _confirm(data: any) {
        deleteDialog(ID);
        setTimeout(() => {
            onConfirmCallback.value();
            resolvePromise.value(data);
        }, 100);
    }

    function _cancel(data: any) {
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

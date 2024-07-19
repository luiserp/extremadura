import { router, useForm } from "@inertiajs/vue3";
import { useDialogs } from "@/Composables/Dialogs/useDialogs";
import { trans } from "laravel-vue-i18n";

const dialog = useDialogs();

export const useBook = () => {

    const form = useForm({
        title: "",
        category_id: "",
        author_id: "",
        description: "",
        year: "",
        catalog: "",
        editorial_id: "",
        city_id: "",
    });

    const showBook = (id: number) => {
        console.log("show book");

        router.get(route("books.detail", id));
    };

    const deleteBook = async (id: number) => {
        const res = await dialog.show({
            title: trans("book.delete_book"),
            subtitle: trans("book.delete_book_subtitle"),
            message: trans("book.delete_book_message"),
        });

        if (!res) {
            return;
        }

        router.delete(route("books.delete", id));
    };

    const editBook = (id: number) => {
        router.get(route("books.edit", id));
    };

    const updateBook = (id: number) => {
        form.put(route("books.update", id));
    };

    return {
        form,
        showBook,
        deleteBook,
        editBook,
        updateBook,
    };
};

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
            size: "lg",
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

    const calculateEmbedding = async (book: App.Dtos.BookDto | null) => {

        console.log("calculate embedding", book);
        console.log("calculate embedding", book?.id);


        const res = await dialog.show({
            title: trans("book.calculate_embeddings"),
            subtitle: trans("book.calculate_embeddings_subtitle"),
            message: trans("book.calculate_embeddings_message"),
            size: "lg",
        });

        if (!res) {
            return;
        }

        router.get(
            route("books.calculate-embedding"),
            {
                to: book ? book.id : null,
            },
            { preserveScroll: true }
        );
    };

    const calculateSentiment = async (book: App.Dtos.BookDto | null) => {

        const res = await dialog.show({
            title: trans("book.calculate_sentiment"),
            subtitle: trans("book.calculate_sentiment_subtitle"),
            message: trans("book.calculate_sentiment_message"),
            size: "lg",
        });

        if (!res) {
            return;
        }

        router.get(
            route("books.calculate-sentiment"),
            {
                to: book ? book.id : null,
            },
            { preserveScroll: true }
        );
    };

    return {
        form,
        showBook,
        deleteBook,
        editBook,
        updateBook,
        calculateEmbedding,
        calculateSentiment,
    };
};

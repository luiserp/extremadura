import { router, useForm } from "@inertiajs/vue3";
import { useDialogs } from "@/Composables/Dialogs/useDialogs";
import { trans } from "laravel-vue-i18n";
import { App } from "@/types/app";
import { watch } from "vue";

const dialog = useDialogs();

export const useBook = () => {
    const form = useForm<{
        title: string;
        category: App.Dtos.CategoryDto | null;
        authors: App.Dtos.AuthorDto[];
        description: string;
        year: string;
        catalog: string;
        editorial: string | null;
        city: string | null;
        reference: string | null;
    }>({
        title: "",
        category: null,
        authors: [],
        description: "",
        year: "",
        catalog: "",
        editorial: "",
        city: "",
        reference: "",
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

    const deleteAllBooks = async () => {
        const res = await dialog.show({
            title: trans("book.delete_all_books"),
            subtitle: trans("book.delete_all_books_subtitle"),
            message: trans("book.delete_all_books_message"),
            size: "lg",
        });

        if (!res) {
            return;
        }

        router.delete(route("books.delete-all"));
    };

    const editBook = (id: number) => {
        router.get(route("books.edit", id));
    };

    const updateBook = (id: number) => {
        form.put(route("books.update", id), {
            preserveScroll: true,
        });
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

    const createDescription = async (books: App.Dtos.BookDto[] | null) => {
        const res = await dialog.show({
            title: trans("book.book_create_prompt"),
            subtitle: trans("book.book_create_prompt_subtitle"),
            message: trans("book.book_create_prompt_message"),
            size: "lg",
        });

        if (!res) {
            return;
        }

        const ids = books ? books.map((book) => book.id) : [];

        router.get(
            route("books.create-description"),
            {
                to: books ? ids : null,
            },
            { preserveScroll: true }
        );
    };

    const generateImage = async (books: App.Dtos.BookDto[] | null) => {
        const res = await dialog.show({
            title: trans("book.book_generate_image"),
            subtitle: trans("book.book_generate_image_subtitle"),
            message: trans("book.book_generate_image_message"),
            size: "lg",
        });

        if (!res) {
            return;
        }

        console.log("generate image", books);


        const ids = books ? books.map((book) => book.id) : [];

        router.get(
            route("books.generate-image"),
            {
                to: books ? ids : null,
            },
            { preserveScroll: true }
        );
    };

    const calculateStats = async (book: App.Dtos.BookDto | null) => {
        const res = await dialog.show({
            title: trans("book.calculate_stats"),
            subtitle: trans("book.calculate_stats_subtitle"),
            message: trans("book.calculate_stats_message"),
            size: "lg",
        });

        if (!res) {
            return;
        }

        router.get(route("books.calculate-stats"), {},{ preserveScroll: true });
    };

    const checkBook = async (book: App.Dtos.BookDto | null) => {
        router.get(
            route("books.check-data"),
            {
                to: book ? book.id : null,
            },
            { preserveScroll: true }
        );
    };

    const deleteImage = async (imageId: number) => {
        console.log("delete image", imageId);
    };


    const setForm = (book: App.Dtos.BookDto) => {
        form.title = book.title;
        form.authors = book.authors;
        form.description = book.description;
        form.year = book.year;
        form.catalog = book.catalog;
        form.editorial = book.editorial;
        form.city = book.city;
        form.category = book.category;
        form.reference = book.reference;
    };

    // Test
    watch(form, (value) => {
        console.log("form", value);
    });

    return {
        form,
        setForm,
        checkBook,
        showBook,
        deleteBook,
        deleteAllBooks,
        editBook,
        updateBook,
        calculateEmbedding,
        calculateSentiment,
        calculateStats,
        generateImage,
        createDescription,
        deleteImage,
    };
};

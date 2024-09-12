<?php

return [
    'books' => 'Libros',
    'book' => 'Libro',
    'title' => 'Título',
    'description' => 'Descripción',
    'year' => 'Año',
    'catalog' => 'Catálogo',
    'category' => 'Categoría',
    'editorial' => 'Editorial',
    'authors' => 'Autores',
    'city' => 'Ciudad',
    'reference' => 'Referencia completa',
    'images' => 'Imágenes',
    'prompt' => 'Prompt',

    // Actions
    'delete_book' => 'Eliminar libro',
    'delete_book_subtitle' => '¿Estás seguro de que quieres eliminar este libro?',
    'delete_book_message' => 'Una vez eliminado, no podrás recuperar este libro.',

    'calculate_embeddings' => 'Calcular embeddings',
    'calculate_embeddings_subtitle' => '¿Estás seguro de que quieres calcular los embeddings?',
    'calculate_embeddings_message' => 'Esta accion tomara un tiempo, una vez calculados, te enviaremos una notificacion.',

    'calculate_sentiment' => 'Calcular sentimientos',
    'calculate_sentiment_subtitle' => '¿Estás seguro de que quieres calcular los sentimientos?',
    'calculate_sentiment_message' => 'Esta accion tomara un tiempo, una vez calculados, te enviaremos una notificacion.',

    'data_check_ok' => 'Data check OK',
    'data_check_error' => 'Data check error',

    // Messages
    'book_created' => 'Libro creado correctamente.',
    'book_updated' => 'Libro actualizado correctamente.',
    'book_deleted' => 'Libro eliminado correctamente.',
    'book_calculated_embeddings' => 'Embeddings calculados correctamente.',
    'book_calculated_sentiment' => 'Sentimientos calculados correctamente.',
    'book_calculating_embeddings' => 'Calculando embeddings...',
    'book_calculating_sentiment' => 'Calculando sentimientos...',

    // Titles
    'has_embeddings' => 'Tiene datos de embeddings',
    'has_sentiment' => 'Tiene datos de analisis de sentimientos',
    'has_description' => 'Tiene datos de descripción',
    'has_images' => 'Tiene imágenes',

    'import_books_in_progress' => 'El archivo se está importando. Recibirás una notificación cuando el proceso haya finalizado.',
    'import_books_success' => 'Los libros se han importado correctamente.',
    'import_books_error' => 'Se ha producido un error al importar los libros.',

    'export_books_error' => 'Se ha producido un error al exportar los libros.',
    'export_books_success' => 'Los libros se han exportado correctamente.',
    'export_books_in_progress' => 'Los libros se están exportando. Recibirás una notificación cuando el proceso haya finalizado.',

    'delete_all_books' => 'Eliminar todos los libros',
    'delete_all_books_subtitle' => '¿Estás seguro de que quieres eliminar todos los libros?',
    'delete_all_books_message' => 'Una vez eliminados, no podrás recuperar los libros.',
    'delete_all_books_in_progress' => 'Se están eliminando todos los libros. Recibirás una notificación cuando el proceso haya finalizado.',
    'delete_all_books_success' => 'Todos los libros han sido eliminados correctamente.',
    'delete_all_books_error' => 'Se ha producido un error al eliminar todos los libros.',

    // Calculate stats
    'calculate_stats' => 'Calcular estadísticas',
    'calculate_stats_subtitle' => '¿Estás seguro de que quieres calcular las estadísticas?',
    'calculate_stats_message' => 'Esta acción tomará un tiempo, una vez calculadas, te enviaremos una notificación.',

    'calculate_stats_in_progress' => 'Se están calculando las estadísticas. Recibirás una notificación cuando el proceso haya finalizado.',
    'calculate_stats_success' => 'Las estadísticas se han calculado correctamente.',
    'calculate_stats_error' => 'Se ha producido un error al calcular las estadísticas.',

    // Stats
    'stats' => 'Estadísticas',
    'books_per_city' => 'Libros por ciudad',
    'books_per_editorial' => 'Libros por editorial',
    'books_per_category' => 'Libros por categoría',
    'books_per_year' => 'Libros por año',
    'books_per_author' => 'Libros por autor',
    'books_per_city_per_category' => 'Libros por ciudad y categoría',

    // Prompt
    'book_create_prompt' => 'Generar descripción',
    'book_create_prompt_subtitle' => '¿Estás seguro de que quieres generar la descripción del libro?',
    'book_create_prompt_message' => 'Esta acción tomará un tiempo, una vez generada, te enviaremos una notificación.',
    'book_create_prompt_in_progress' => 'Descripción del libro generándose automáticamente...',
    'book_create_prompt_success' => 'Descripción del libro generada correctamente.',
    'book_create_prompt_error' => 'Se ha producido un error al generar la descripción del libro.',

    // Generate image
    'book_generate_image' => 'Generar imagen',
    'book_generate_image_subtitle' => '¿Estás seguro de que quieres generar la imagen del libro?',
    'book_generate_image_message' => 'Esta acción tomará un tiempo, una vez generada, te enviaremos una notificación.',
    'book_generate_image_in_progress' => 'Imagen del libro generándose automáticamente...',
    'book_generate_image_success' => 'Imagen del libro generada correctamente.',
    'book_generate_image_error' => 'Se ha producido un error al generar la imagen del libro.',
];

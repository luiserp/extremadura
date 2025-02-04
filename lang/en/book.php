<?php

return [
    'books' => 'Books',
    'book' => 'Book',
    'title' => 'Title',
    'description' => 'Description',
    'year' => 'Year',
    'catalog' => 'Catalog',
    'category' => 'Category',
    'editorial' => 'Editorial',
    'authors' => 'Authors',
    'city' => 'City',
    'reference' => 'Full Reference',
    'images' => 'Images',
    'prompt' => 'Prompt',

    // Actions
    'delete_book' => 'Delete book',
    'delete_book_subtitle' => 'Are you sure you want to delete this book?',
    'delete_book_message' => 'Once deleted, you will not be able to recover this book.',

    'calculate_embeddings' => 'Calculate embeddings',
    'calculate_embeddings_subtitle' => 'Are you sure you want to calculate the embeddings?',
    'calculate_embeddings_message' => 'This action will take some time, once calculated, we will send you a notification.',

    'calculate_sentiment' => 'Calculate sentiment',
    'calculate_sentiment_subtitle' => 'Are you sure you want to calculate the sentiments?',
    'calculate_sentiment_message' => 'This action will take some time, once calculated, we will send you a notification.',

    'data_check_ok' => 'Data check OK',
    'data_check_error' => 'Data check error',

    // Messages
    'book_created' => 'Book created correctly.',
    'book_updated' => 'Book updated correctly.',
    'book_deleted' => 'Book deleted correctly.',
    'book_calculated_embeddings' => 'Embeddings calculated correctly.',
    'book_calculated_sentiment' => 'Sentiments calculated correctly.',
    'book_calculating_embeddings' => 'Calculando embeddings...',
    'book_calculating_sentiment' => 'Calculando sentimientos...',

    // Titles
    'has_embeddings' => 'Has embeddings data',
    'has_sentiment' => 'Has sentiment analysis data',
    'has_description' => 'Has description data',
    'has_images' => 'Has images',

    'import_books_in_progress' => 'The file is being imported. You will receive a notification when the process is complete.',
    'import_books_success' => 'Books have been imported successfully.',
    'import_books_error' => 'An error occurred while importing the books.',

    'export_books_error' => 'An error occurred while exporting the books.',
    'export_books_success' => 'Books have been exported successfully.',
    'export_books_in_progress' => 'The books are being exported. You will receive a notification when the process is complete.',

    'delete_all_books' => 'Delete all books',
    'delete_all_books_subtitle' => 'Are you sure you want to delete all books?',
    'delete_all_books_message' => 'Once deleted, you will not be able to recover the books.',
    'delete_all_books_in_progress' => 'All books are being deleted. You will receive a notification when the process is complete.',
    'delete_all_books_success' => 'All books have been deleted successfully.',
    'delete_all_books_error' => 'An error occurred while deleting all books.',

    // Calculate stats
    'calculate_stats' => 'Calculate statistics',
    'calculate_stats_subtitle' => 'Are you sure you want to calculate the statistics?',
    'calculate_stats_message' => 'This action will take some time, once calculated, we will send you a notification.',

    'calculate_stats_in_progress' => 'Statistics are being calculated. You will receive a notification when the process is complete.',
    'calculate_stats_success' => 'Statistics have been calculated successfully.',
    'calculate_stats_error' => 'An error occurred while calculating the statistics.',

    'stats' => 'Statistics',
    'books_per_city' => 'Books per city',
    'books_per_editorial' => 'Books per editorial',
    'books_per_category' => 'Books per category',
    'books_per_year' => 'Books per year',
    'books_per_author' => 'Books per author',
    'books_per_city_per_category' => 'Books per city and category',

    // Prompt
    'book_create_prompt' => 'Generate description',
    'book_create_prompt_subtitle' => 'Are you sure you want to generate the book description?',
    'book_create_prompt_message' => 'This action will take some time, once generated, we will send you a notification.',
    'book_create_prompt_in_progress' => 'The book description is being generated. You will receive a notification when the process is complete.',
    'book_create_prompt_success' => 'The book description has been generated successfully.',
    'book_create_prompt_error' => 'An error occurred while generating the book description.',

    // Generate image
    'book_generate_image' => 'Generate image',
    'book_generate_image_subtitle' => 'Are you sure you want to generate the book image?',
    'book_generate_image_message' => 'This action will take some time, once generated, we will send you a notification.',
    'book_generate_image_in_progress' => 'The book image is being generated. You will receive a notification when the process is complete.',
    'book_generate_image_success' => 'The book image has been generated successfully.',
    'book_generate_image_error' => 'An error occurred while generating the book image.',
];

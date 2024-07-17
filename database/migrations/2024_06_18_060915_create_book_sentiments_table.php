<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('book_sentiments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->onDelete('cascade');

            $table->string('sentiment_model');
            $table->double('positive_sentiment')->default(0);
            $table->double('negative_sentiment')->default(0);
            $table->double('neutral_sentiment')->default(0);

            $table->string('embeddings_model');
            $table->json('embeddings');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_nlps');
    }
};

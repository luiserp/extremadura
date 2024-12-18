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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->integer('year')->nullable();
            $table->string('catalog')->nullable();
            $table->string('color')->nullable();
            $table->string('editorial')->nullable();
            $table->string('city')->nullable();
            $table->text('reference')->nullable();
            $table->boolean('active')->default(false);
            $table->boolean('ready')->default(false);

            $table->foreignId('category_id')->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};

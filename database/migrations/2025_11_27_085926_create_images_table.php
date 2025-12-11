<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->dateTime('created_at', 6)->nullable();
            $table->text('description')->nullable();
            $table->string('file_path', 255);
            $table->bigInteger('file_size')->nullable();
            $table->string('file_type', 50)->nullable();
            $table->string('title', 255)->nullable();
            $table->enum('visibility', ['public', 'private'])->nullable();

            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete(); // équivaut à ON DELETE SET NULL

            $table->foreignId('subcategory_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
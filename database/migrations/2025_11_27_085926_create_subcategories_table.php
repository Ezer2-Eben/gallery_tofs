<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();
            $table->dateTime('created_at', 6)->nullable();
            $table->text('description')->nullable();
            $table->string('name', 100);
            $table->foreignId('category_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->foreignId('admin_id')
                  ->nullable()
                  ->constrained('admins') // ← change en 'admincar' si besoin
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subcategories');
    }
};
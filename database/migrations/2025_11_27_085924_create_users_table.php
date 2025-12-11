<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('age')->nullable();
            $table->dateTime('created_at', 6)->nullable(); // microsecondes
            $table->string('email', 150)->unique();
            $table->string('first_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('last_name', 20)->nullable();
            $table->string('password');
            $table->string('username', 100)->unique();
            $table->boolean('enabled'); // équivaut à BIT(1)
            // Pas de `updated_at`, car ton schéma SQL n’en a pas
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
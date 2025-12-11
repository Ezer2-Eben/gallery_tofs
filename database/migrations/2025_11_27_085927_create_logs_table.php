<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('action', 255);
            $table->dateTime('created_at', 6)->nullable();
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
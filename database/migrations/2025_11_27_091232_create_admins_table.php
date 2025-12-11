<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->dateTime('created_at', 6)->nullable();
            $table->dateTime('updated_at', 6)->nullable(); // ajouté car utile pour les admins (convention Laravel)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
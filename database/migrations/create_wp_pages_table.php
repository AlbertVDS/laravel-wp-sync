<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wp_pages', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('title');
            $table->longText('content')->nullable();
            $table->string('slug')->unique();
            $table->string('status', 50);
            $table->unsignedInteger('menu_order')->default(0);
            $table->string('link');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wp_pages');
    }
};

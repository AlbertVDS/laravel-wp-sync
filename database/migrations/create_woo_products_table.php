<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('woo_products', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('status', 50);
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('regular_price', 10, 2)->nullable();
            $table->string('stock_status', 50)->default('instock');
            $table->integer('stock_quantity')->nullable();
            $table->json('categories')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('woo_products');
    }
};

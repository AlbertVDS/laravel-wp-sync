<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('woo_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('status', 50);
            $table->string('currency', 10);
            $table->decimal('total', 10, 2);
            $table->string('billing_email');
            $table->string('billing_first_name');
            $table->string('billing_last_name');
            $table->json('line_items')->nullable();
            $table->timestamp('date_created')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('woo_orders');
    }
};

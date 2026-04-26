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
        Schema::create('pricing_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('price_display');
            $table->string('description')->nullable();
            $table->text('features')->nullable(); // Newline separated or JSON
            $table->boolean('is_popular')->default(false);
            $table->integer('order_weight')->default(0);
            $table->string('cta_text')->default('Pilih Paket');
            $table->string('cta_link')->default('/register');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_plans');
    }
};

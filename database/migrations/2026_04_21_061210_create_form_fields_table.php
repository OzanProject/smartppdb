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
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_section_id')->constrained()->cascadeOnDelete();
            $table->string('label');
            $table->string('name'); // JSON key
            $table->string('type')->default('text'); // text, number, date, select, textarea
            $table->json('options')->nullable(); // for selects/radio
            $table->boolean('is_required')->default(false);
            $table->integer('order_weight')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_fields');
    }
};

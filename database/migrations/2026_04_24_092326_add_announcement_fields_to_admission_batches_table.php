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
        Schema::table('admission_batches', function (Blueprint $table) {
            $table->date('announcement_date')->nullable()->after('end_date');
            $table->boolean('is_announcement_published')->default(false)->after('announcement_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admission_batches', function (Blueprint $table) {
            $table->dropColumn(['announcement_date', 'is_announcement_published']);
        });
    }
};

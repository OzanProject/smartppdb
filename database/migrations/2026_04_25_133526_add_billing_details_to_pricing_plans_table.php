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
        Schema::table('pricing_plans', function (Blueprint $table) {
            $table->decimal('price', 15, 2)->default(0)->after('price_display');
            $table->string('billing_cycle')->default('monthly')->after('price'); // monthly, yearly, custom
            $table->integer('trial_days')->default(0)->after('billing_cycle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pricing_plans', function (Blueprint $table) {
            $table->dropColumn(['price', 'billing_cycle', 'trial_days']);
        });
    }
};

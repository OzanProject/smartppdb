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
        // Add Hero & Stats columns to schools
        Schema::table('schools', function (Blueprint $table) {
            $table->string('hero_title')->nullable()->after('logo');
            $table->text('hero_description')->nullable()->after('hero_title');
            $table->string('stats_acc_label')->nullable()->after('hero_description');
            $table->string('stats_acc_value')->nullable()->after('stats_acc_label');
            $table->string('stats_count_label')->nullable()->after('stats_acc_value');
            $table->string('stats_count_value')->nullable()->after('stats_count_label');
            $table->string('stats_grad_label')->nullable()->after('stats_count_value');
            $table->string('stats_grad_value')->nullable()->after('stats_grad_label');
        });

        // Create landing_contents table
        Schema::create('landing_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['program', 'testimonial', 'faq']);
            $table->string('title');
            $table->string('subtitle')->nullable(); // For alumni role or additional info
            $table->text('content')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('landing_contents');
        
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn([
                'hero_title', 'hero_description', 
                'stats_acc_label', 'stats_acc_value', 
                'stats_count_label', 'stats_count_value', 
                'stats_grad_label', 'stats_grad_value'
            ]);
        });
    }
};

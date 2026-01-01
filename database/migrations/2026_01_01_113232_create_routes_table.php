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
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('origin_id')->constrained('destinations')->cascadeOnDelete();
            $table->foreignId('destination_id')->constrained('destinations')->cascadeOnDelete();
            $table->decimal('distance', 8, 2)->nullable()->comment('Distance in km');
            $table->integer('duration')->nullable()->comment('Duration in minutes');
            $table->decimal('base_price', 12, 2)->default(0)->comment('Base price in IDR');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();

            // Prevent duplicate routes
            $table->unique(['origin_id', 'destination_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};

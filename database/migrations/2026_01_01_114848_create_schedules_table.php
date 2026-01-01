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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ship_id')->constrained()->cascadeOnDelete();
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->unsignedInteger('price');
            $table->unsignedInteger('available_seats');
            $table->json('days_of_week')->nullable(); // [0,1,2,3,4,5,6] = Sun-Sat
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();

            // Index for faster searches
            $table->index(['route_id', 'is_active']);
            $table->index(['departure_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};

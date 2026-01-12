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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('schedule_id')->constrained()->cascadeOnDelete();
            $table->date('travel_date');
            $table->integer('passenger_count');
            $table->integer('total_amount');
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('contact_phone');
            $table->enum('status', ['pending', 'confirmed', 'paid', 'cancelled', 'completed', 'refunded'])->default('pending');
            $table->enum('payment_status', ['unpaid', 'pending', 'paid', 'failed', 'expired', 'refunded'])->default('unpaid');
            $table->string('payment_method')->nullable();
            $table->string('payment_token')->nullable();
            $table->string('payment_url')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['order_number']);
            $table->index(['status']);
            $table->index(['payment_status']);
            $table->index(['travel_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

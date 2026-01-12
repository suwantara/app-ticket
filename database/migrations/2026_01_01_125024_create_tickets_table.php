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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('passenger_id')->constrained()->onDelete('cascade');
            $table->string('ticket_number', 20)->unique(); // TKT-YYYYMMDD-XXXXX
            $table->string('qr_code', 100)->unique(); // Unique QR code string
            $table->string('qr_code_path')->nullable(); // Path to QR image
            $table->enum('status', ['active', 'used', 'cancelled', 'expired'])->default('active');
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_until')->nullable();
            $table->timestamp('used_at')->nullable();
            $table->string('used_by')->nullable(); // Staff who checked the ticket
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['order_id', 'status']);
            $table->index('ticket_number');
            $table->index('qr_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};

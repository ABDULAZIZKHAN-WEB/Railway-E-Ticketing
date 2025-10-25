<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cancellations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings');
            $table->foreignId('cancelled_by_user_id')->constrained('users');
            $table->text('cancellation_reason')->nullable();
            $table->decimal('refund_amount', 10, 2);
            $table->enum('refund_status', ['pending', 'processed', 'completed'])->default('pending');
            $table->foreignId('processed_by_admin_id')->nullable()->constrained('users');
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cancellations');
    }
};
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
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('paymentStatus')->default('Pending')->after('bookingDepositStatus');
            $table->timestamp('paymentSubmittedAt')->nullable()->after('paymentStatus');
            $table->timestamp('paymentApprovedAt')->nullable()->after('paymentSubmittedAt');
            $table->timestamp('paymentRejectedAt')->nullable()->after('paymentApprovedAt');
            $table->unsignedBigInteger('approvedBy')->nullable()->after('paymentRejectedAt');
            $table->text('rejectionReason')->nullable()->after('approvedBy');

            $table->foreign('approvedBy')->references('staffID')->on('staffs')->onDelete('set null');
        });

        Schema::create('payment_receipts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('orderId');
            $table->string('receiptPath');
            $table->timestamp('uploadedAt')->nullable();
            $table->string('status')->default('Pending');
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('orderId')->references('bookingID')->on('bookings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_receipts');

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['approvedBy']);
            $table->dropColumn([
                'paymentStatus',
                'paymentSubmittedAt',
                'paymentApprovedAt',
                'paymentRejectedAt',
                'approvedBy',
                'rejectionReason'
            ]);
        });
    }
};

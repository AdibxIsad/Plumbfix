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
            $table->timestamp('cancelled_at')->nullable()->after('paymentStatus');
            $table->string('cancellation_reason')->nullable()->after('cancelled_at');
            $table->text('cancellation_description')->nullable()->after('cancellation_reason');
            $table->string('refund_status')->default('not_applicable')->after('cancellation_description'); // 'not_applicable', 'pending', 'refunded'
            $table->decimal('refund_amount', 8, 2)->default(0.00)->after('refund_status');
            $table->timestamp('refund_completed_at')->nullable()->after('refund_amount');
            $table->string('refund_receipt_path')->nullable()->after('refund_completed_at');
            $table->text('refund_remarks')->nullable()->after('refund_receipt_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'cancelled_at',
                'cancellation_reason',
                'cancellation_description',
                'refund_status',
                'refund_amount',
                'refund_completed_at',
                'refund_receipt_path',
                'refund_remarks'
            ]);
        });
    }
};

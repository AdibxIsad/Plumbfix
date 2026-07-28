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
            $table->string('bookingDepositReceipt')->nullable()->after('bookingAttachment');
            $table->decimal('bookingDepositAmount', 8, 2)->default(50.00)->after('bookingDepositReceipt');
            $table->string('bookingDepositStatus')->default('pending')->after('bookingDepositAmount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['bookingDepositReceipt', 'bookingDepositAmount', 'bookingDepositStatus']);
        });
    }
};

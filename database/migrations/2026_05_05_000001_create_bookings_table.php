<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * customer_id → customers.customerID
     * staff_id    → staffs.staffID (nullable: assigned later)
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('bookingID');
            $table->unsignedBigInteger('customerID');
            $table->unsignedBigInteger('staffID')->nullable();
            $table->string('bookingType');
            $table->string('bookingProblem');
            $table->text('bookingIssueDescription')->nullable();
            $table->date('bookingDate');
            $table->time('bookingTime');
            $table->string('bookingStatus')->default('pending');
            $table->timestamps();

            // FK → customers
            $table->foreign('customerID')
                  ->references('customerID')->on('customers')
                  ->onDelete('cascade');

            // FK → staffs (nullable: booking may not have staff assigned yet)
            $table->foreign('staffID')
                  ->references('staffID')->on('staffs')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};

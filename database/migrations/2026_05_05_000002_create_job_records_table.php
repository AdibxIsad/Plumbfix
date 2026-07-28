<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * bookingID → bookings.bookingID  (1-to-1)
     * staffID   → staffs.staffID
     */
    public function up(): void
    {
        Schema::create('job_records', function (Blueprint $table) {
            $table->id('jobRecordID');
            $table->unsignedBigInteger('bookingID')->unique(); // 1-to-1 with booking
            $table->unsignedBigInteger('staffID');
            $table->date('jobRecordCompletionDate')->nullable();
            $table->double('jobRecordTotalCost')->default(0);
            $table->text('jobRecordNotes')->nullable();
            $table->timestamps();

            // FK → bookings (1-to-1)
            $table->foreign('bookingID')
                  ->references('bookingID')->on('bookings')
                  ->onDelete('cascade');

            // FK → staffs
            $table->foreign('staffID')
                  ->references('staffID')->on('staffs')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_records');
    }
};

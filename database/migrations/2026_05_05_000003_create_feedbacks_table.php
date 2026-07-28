<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * customerID → customers.customerID
     * Feedback is linked to Customer only (not per-booking), as per DCD.
     */
    public function up(): void
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id('feedbackID');
            $table->unsignedBigInteger('customerID');
            $table->text('feedbackComments')->nullable();
            $table->integer('feedbackRating'); // 1 to 5
            $table->timestamps();

            // FK → customers
            $table->foreign('customerID')
                  ->references('customerID')->on('customers')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};

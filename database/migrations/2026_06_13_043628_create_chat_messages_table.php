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
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id('chatMessageID');
            $table->unsignedBigInteger('bookingID');
            $table->string('sender_type'); // 'customer' or 'staff'
            $table->unsignedBigInteger('sender_id');
            $table->text('message');
            $table->timestamps();

            // Foreign keys
            $table->foreign('bookingID')->references('bookingID')->on('bookings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};

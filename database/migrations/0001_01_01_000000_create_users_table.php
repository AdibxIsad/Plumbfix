<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Customers and Staff are kept as SEPARATE tables (following the DCD).
     * Staff has a recursive self-reference: admin_id -> staffs.staffID
     */
    public function up(): void
    {
        // ── CUSTOMERS table ──────────────────────────────────────────────
        Schema::create('customers', function (Blueprint $table) {
            $table->id('customerID');
            $table->string('customerName');
            $table->string('customerEmail')->unique();
            $table->string('customerPhoneNo')->nullable();
            $table->text('customerAddress')->nullable();
            $table->string('customerPassword');
            $table->rememberToken();
            $table->timestamps();
        });

        // ── STAFFS table (recursive: admin_id references own staffID) ────
        Schema::create('staffs', function (Blueprint $table) {
            $table->id('staffID');
            $table->string('staffEmail')->unique();
            $table->string('staffName');
            $table->string('staffPhoneNo')->nullable();
            $table->string('staffPassword');
            // Self-referencing FK: which staff member is the admin above them
            $table->unsignedBigInteger('adminID')->nullable();
            $table->rememberToken();
            $table->timestamps();

            // Recursive relationship: admin is also a staff member
            $table->foreign('adminID')->references('staffID')->on('staffs')->onDelete('set null');
        });

        // ── PASSWORD RESET TOKENS ────────────────────────────────────────
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // ── SESSIONS ─────────────────────────────────────────────────────
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->unsignedBigInteger('user_id')->nullable()->index(); // generic, not FK
            $table->string('user_type')->nullable();                    // 'customer' or 'staff'
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('staffs');
        Schema::dropIfExists('customers');
    }
};

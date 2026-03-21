<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            
            // Personal Info
            $table->string('title')->nullable();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            
            // Contact
            $table->string('phone')->unique();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            
            // Employment
            $table->string('occupation')->nullable();
            $table->string('employer_name')->nullable();
            $table->string('monthly_income_range')->nullable();

            // Next of Kin
            $table->string('next_of_kin_name')->nullable();
            $table->string('nok_relationship')->nullable();
            $table->string('next_of_kin_phone')->nullable();
            
            // Emergency Contact (if different)
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();

            // Identification
            $table->string('id_type')->nullable(); // National ID, Voter's Card, etc.
            $table->string('id_number')->nullable();
            $table->string('id_card_path')->nullable();
            $table->string('passport_photo_path')->nullable();

            // Financial / Payment
            $table->string('account_number')->unique()->nullable();
            $table->string('payment_method')->nullable(); // Bank Transfer, Online, Cash
            $table->string('payment_proof_path')->nullable(); // Path to receipt image
            
            // System
            $table->string('application_ref')->unique()->nullable(); // APP-2024-XXXX
            $table->string('status')->default('pending'); // active, inactive, pending
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};

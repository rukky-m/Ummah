<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loan_committee_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained(); // The committee member
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->text('comment')->nullable();
            $table->string('signature_path')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
            
            // Ensure a user can only review a loan once
            $table->unique(['loan_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_committee_approvals');
    }
};

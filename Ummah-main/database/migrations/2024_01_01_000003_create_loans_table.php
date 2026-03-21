<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->string('application_number')->unique()->nullable();
            $table->decimal('amount', 12, 2);
            $table->string('purpose')->nullable();
            $table->text('narration')->nullable();
            $table->integer('duration_months');
            $table->string('repayment_frequency')->default('monthly'); // monthly, quarterly
            $table->decimal('interest_rate', 5, 2)->default(0);
            $table->decimal('total_repayment', 12, 2);
            $table->string('status')->default('pending'); // pending, submitted, under_review, approved, rejected, disbursed, paid, defaulted
            $table->foreignId('approved_by')->nullable()->constrained('users'); // For quick simple approval if needed, otherwise use committee
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('disbursed_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};

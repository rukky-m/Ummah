<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('savings', function (Blueprint $table) {
            $table->string('status')->default('approved')->after('amount'); // Default to approved for existing records
            $table->string('payment_proof_path')->nullable()->after('notes');
            $table->text('rejection_reason')->nullable()->after('payment_proof_path');
        });
    }

    public function down(): void
    {
        Schema::table('savings', function (Blueprint $table) {
            $table->dropColumn(['status', 'payment_proof_path', 'rejection_reason']);
        });
    }
};

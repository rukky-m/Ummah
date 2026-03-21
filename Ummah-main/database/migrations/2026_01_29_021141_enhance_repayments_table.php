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
        Schema::table('repayments', function (Blueprint $table) {
            $table->string('month')->nullable()->after('amount');
            $table->integer('year')->nullable()->after('month');
            $table->string('status')->default('approved')->after('year'); // pending, approved, rejected
            $table->string('proof_path')->nullable()->after('status');
            $table->text('admin_comment')->nullable()->after('proof_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('repayments', function (Blueprint $table) {
            $table->dropColumn(['month', 'year', 'status', 'proof_path', 'admin_comment']);
        });
    }
};

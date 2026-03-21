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
        Schema::table('loan_committee_approvals', function (Blueprint $table) {
            // Add non-unique indices first so foreign keys are satisfied
            $table->index('loan_id');
            $table->index('user_id');
            
            // Drop unique constraint to allow multi-stage approvals same user
            $table->dropUnique(['loan_id', 'user_id']);
            
            // Add stage column to track which stage this approval belongs to
            $table->integer('stage')->nullable()->after('status');
            
            // Re-add unique constraint including stage
            $table->unique(['loan_id', 'user_id', 'stage'], 'loan_user_stage_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_committee_approvals', function (Blueprint $table) {
            $table->dropUnique(['loan_id', 'user_id', 'stage']);
            $table->dropColumn('stage');
            $table->unique(['loan_id', 'user_id']);
        });
    }
};

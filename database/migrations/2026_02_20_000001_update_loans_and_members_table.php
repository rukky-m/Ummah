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
        Schema::table('loans', function (Blueprint $table) {
            // Stage of the loan in the 5-step process
            // 1=Chairman(View), 2=Finance, 3=Auditor, 4=Chairman(Approve), 5=Treasurer(Disburse)
            // Default to 1 for new loans. Existing loans might need a migration script or defaults.
            // For simplicity, we default to 1 (Pending Chairman Review).
            if (!Schema::hasColumn('loans', 'stage')) {
                $table->integer('stage')->default(1)->after('status');
            }
        });

        Schema::table('members', function (Blueprint $table) {
            if (!Schema::hasColumn('members', 'bank_name')) {
                $table->string('bank_name')->nullable()->after('account_number');
            }
            if (!Schema::hasColumn('members', 'account_name')) {
                $table->string('account_name')->nullable()->after('bank_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            if (Schema::hasColumn('loans', 'stage')) {
                $table->dropColumn('stage');
            }
        });

        Schema::table('members', function (Blueprint $table) {
            if (Schema::hasColumn('members', 'bank_name')) {
                $table->dropColumn('bank_name');
            }
            if (Schema::hasColumn('members', 'account_name')) {
                $table->dropColumn('account_name');
            }
        });
    }
};

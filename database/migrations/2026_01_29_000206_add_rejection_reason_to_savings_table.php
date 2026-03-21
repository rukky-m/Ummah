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
        if (! Schema::hasColumn('savings', 'rejection_reason')) {
            Schema::table('savings', function (Blueprint $table) {
                $table->text('rejection_reason')->nullable()->after('payment_proof_path');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('savings', 'rejection_reason')) {
            Schema::table('savings', function (Blueprint $table) {
                $table->dropColumn('rejection_reason');
            });
        }
    }
};

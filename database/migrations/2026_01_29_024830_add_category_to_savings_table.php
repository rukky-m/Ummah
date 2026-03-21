<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('savings', function (Blueprint $table) {
            $table->string('category')->default('Personal Savings')->after('amount');
        });

        // Try to populate existing records based on notes
        DB::table('savings')
            ->where('notes', 'like', '%Contribution%')
            ->update(['category' => 'Contribution']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('savings', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};

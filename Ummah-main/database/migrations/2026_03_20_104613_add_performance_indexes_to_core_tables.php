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
            $table->index('status');
            $table->index('stage');
        });

        Schema::table('savings', function (Blueprint $table) {
            $table->index('status');
            $table->index('category');
            $table->index('type');
        });

        Schema::table('repayments', function (Blueprint $table) {
            $table->index('status');
            $table->index(['month', 'year']);
        });
        
        Schema::table('members', function (Blueprint $table) {
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['stage']);
        });

        Schema::table('savings', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['category']);
            $table->dropIndex(['type']);
        });

        Schema::table('repayments', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['month', 'year']);
        });
        
        Schema::table('members', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });
    }
};

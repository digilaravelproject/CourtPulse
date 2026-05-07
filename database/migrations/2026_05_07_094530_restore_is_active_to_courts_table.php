<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Restore the is_active column to courts table to filter active courts
     * during registration and other operations.
     */
    public function up(): void
    {
        Schema::table('courts', function (Blueprint $table) {
            if (!Schema::hasColumn('courts', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('pincode');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courts', function (Blueprint $table) {
            if (Schema::hasColumn('courts', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};

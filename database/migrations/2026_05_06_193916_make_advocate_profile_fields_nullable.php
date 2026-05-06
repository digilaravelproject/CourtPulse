<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('advocate_profiles', function (Blueprint $table) {
            // Make required fields nullable to allow flexible profile creation
            $table->string('bar_council_number')->nullable()->change();
            $table->string('enrollment_number')->nullable()->change();
            $table->date('enrollment_date')->nullable()->change();
            $table->string('high_court')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('advocate_profiles', function (Blueprint $table) {
            $table->string('bar_council_number')->nullable(false)->change();
            $table->string('enrollment_number')->nullable(false)->change();
            $table->date('enrollment_date')->nullable(false)->change();
            $table->string('high_court')->nullable(false)->change();
        });
    }
};

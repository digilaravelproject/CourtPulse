<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ca_profiles', function (Blueprint $table) {
            // Make required fields nullable to allow flexible profile creation
            $table->string('membership_number')->nullable()->change();
            $table->string('icai_region')->nullable()->change();
            $table->date('membership_date')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('ca_profiles', function (Blueprint $table) {
            $table->string('membership_number')->nullable(false)->change();
            $table->string('icai_region')->nullable(false)->change();
            $table->date('membership_date')->nullable(false)->change();
        });
    }
};

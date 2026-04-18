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
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_group')->nullable()->after('role'); // professional, support, guest
            $table->string('sub_role')->nullable()->after('user_group'); // Court Clerk, IP Clerk, etc.
            $table->string('experience_years')->nullable()->after('sub_role');
            $table->json('capabilities')->nullable()->after('experience_years');
            $table->string('license_number')->nullable()->after('capabilities');
            $table->text('past_employers')->nullable()->after('license_number');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['user_group', 'sub_role', 'experience_years', 'capabilities', 'license_number', 'past_employers']);
        });
    }
};

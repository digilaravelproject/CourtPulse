<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change to string temporarily to avoid ENUM truncation during update
        DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(255)");

        // Map existing roles to new ones
        DB::table('users')->where('role', 'clerk')->update(['role' => 'court_clerk']);
        DB::table('users')->whereIn('role', ['ca', 'cs'])->update(['role' => 'ca_cs']);
        DB::table('users')->where('role', 'ip_attorney')->update(['role' => 'agent']);

        // MySQL Enum modification with new structure
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin', 'admin', 'guest', 'court_clerk', 'ip_clerk', 'advocate', 'ca_cs', 'agent') DEFAULT 'guest'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin', 'admin', 'advocate', 'clerk', 'guest', 'ca', 'cs', 'ip_attorney') DEFAULT 'guest'");
    }
};

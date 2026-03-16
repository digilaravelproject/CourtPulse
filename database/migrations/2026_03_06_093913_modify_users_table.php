<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->enum('role', ['super_admin', 'admin', 'advocate', 'clerk', 'guest', 'ca'])->default('guest');
            $table->enum('status', ['pending', 'active', 'rejected'])->default('pending');
            $table->string('profile_photo')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'role', 'status', 'profile_photo', 'address', 'city', 'state', 'pincode']);
        });
    }
};

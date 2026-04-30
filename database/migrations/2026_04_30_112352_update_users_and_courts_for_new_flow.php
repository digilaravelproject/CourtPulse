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
            if (!Schema::hasColumn('users', 'user_group')) {
                $table->string('user_group')->nullable()->after('role');
            }
            if (!Schema::hasColumn('users', 'status')) {
                $table->string('status')->default('pending')->after('user_group');
            }
            if (!Schema::hasColumn('users', 'court_id')) {
                $table->unsignedBigInteger('court_id')->nullable()->after('status');
            }
            if (!Schema::hasColumn('users', 'experience_years')) {
                $table->integer('experience_years')->nullable()->after('court_id');
            }
        });

        Schema::table('courts', function (Blueprint $table) {
            if (!Schema::hasColumn('courts', 'area')) {
                $table->string('area')->nullable()->after('name');
            }
            if (!Schema::hasColumn('courts', 'city')) {
                $table->string('city')->nullable()->after('area');
            }
            if (!Schema::hasColumn('courts', 'pincode')) {
                $table->string('pincode')->nullable()->after('city');
            }
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['user_group', 'status', 'court_id', 'experience_years']);
        });

        Schema::table('courts', function (Blueprint $table) {
            $table->dropColumn(['area', 'city', 'pincode', 'is_active']);
        });
    }
};

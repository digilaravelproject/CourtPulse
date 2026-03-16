<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('advocate_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('bar_council_number')->unique();
            $table->string('enrollment_number')->unique();
            $table->date('enrollment_date');
            $table->string('high_court');
            $table->json('practice_areas')->nullable(); // e.g. ["Civil","Criminal","Family"]
            $table->integer('experience_years')->default(0);
            $table->text('bio')->nullable();
            $table->string('office_address')->nullable();
            $table->string('office_phone')->nullable();
            $table->string('website')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advocate_profiles');
    }
};

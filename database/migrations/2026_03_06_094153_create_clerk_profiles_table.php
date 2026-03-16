
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('clerk_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('clerk_id_number')->unique();
            $table->string('court_name');
            $table->string('court_city');
            $table->string('court_state');
            $table->string('department')->nullable();
            $table->integer('experience_years')->default(0);
            $table->text('bio')->nullable();
            $table->json('advocate_contacts')->nullable(); // advocates they know
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clerk_profiles');
    }
};

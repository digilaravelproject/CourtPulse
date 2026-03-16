
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ca_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('membership_number')->unique();
            $table->string('icai_region');
            $table->date('membership_date');
            $table->json('specializations')->nullable(); // ["Tax","Audit","Corporate"]
            $table->integer('experience_years')->default(0);
            $table->text('bio')->nullable();
            $table->string('firm_name')->nullable();
            $table->string('office_address')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ca_profiles');
    }
};

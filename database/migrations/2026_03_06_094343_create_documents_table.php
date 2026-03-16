
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('document_type', [
                // Advocate documents
                'bar_council_certificate',
                'enrollment_certificate',
                'degree_certificate',
                'aadhar_card',
                'pan_card',
                'photo_id',
                'practice_certificate',
                // Clerk documents
                'clerk_appointment_letter',
                'court_id_card',
                'service_certificate',
                // CA documents
                'ca_membership_certificate',
                'icai_certificate',
                'firm_registration',
                // Common
                'profile_photo',
                'other'
            ]);
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_size')->nullable();
            $table->string('mime_type')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};

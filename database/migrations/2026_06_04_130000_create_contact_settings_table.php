<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contact_settings', function (Blueprint $table) {
            $table->id();
            $table->string('office_image')->nullable();
            $table->string('office_title')->default('DockIt Office HQ');
            $table->string('address_title')->default('Headquarters');
            $table->text('address_content')->nullable();
            $table->string('phone_title')->default('Direct Line');
            $table->string('phone_number')->default('+91 00000 00000');
            $table->string('phone_hours')->default('Mon - Fri, 9AM - 6PM');
            $table->string('email_title')->default('General Inquiries');
            $table->string('email_support')->default('support@dockit.in');
            $table->string('email_info')->default('info@dockit.in');
            $table->text('support_text')->nullable();
            $table->string('footer_badge')->default('DockIt Operations Network Grounded In Excellence');
            $table->timestamps();
        });

        // Seed initial default settings
        DB::table('contact_settings')->insert([
            'office_image' => null,
            'office_title' => 'DockIt Office HQ',
            'address_title' => 'Headquarters',
            'address_content' => 'Complete Address To Be Provided Here.',
            'phone_title' => 'Direct Line',
            'phone_number' => '+91 00000 00000',
            'phone_hours' => 'Mon - Fri, 9AM - 6PM',
            'email_title' => 'General Inquiries',
            'email_support' => 'support@dockit.in',
            'email_info' => 'info@dockit.in',
            'support_text' => 'Our support channel is monitored 24/7 for critical procedural inquiries and professional onboarding assistance across India.',
            'footer_badge' => 'DockIt Operations Network Grounded In Excellence',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_settings');
    }
};

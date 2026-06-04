<?php

namespace Tests\Feature;

use App\Models\ContactSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ContactSettingsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create standard roles for authorization tests
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'guest', 'guard_name' => 'web']);

        // Update the existing row seeded by the migration, or create it if not present
        $settings = ContactSetting::first();
        $data = [
            'office_title' => 'Default Office HQ',
            'address_title' => 'Default Headquarters',
            'address_content' => '123 Default St',
            'phone_title' => 'Direct Line',
            'phone_number' => '+91 00000 00000',
            'phone_hours' => '9AM - 6PM',
            'email_title' => 'Inquiries',
            'email_support' => 'support@dockit.in',
            'email_info' => 'info@dockit.in',
            'support_text' => 'Support is active 24/7',
            'footer_badge' => 'DockIt Operations Grounded in Excellence',
        ];

        if ($settings) {
            $settings->update($data);
        } else {
            ContactSetting::create($data);
        }
    }

    /**
     * Test admin can access contact settings panel.
     */
    public function test_admin_can_access_contact_settings_index(): void
    {
        $admin = User::factory()->create(['status' => 'active']);
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('admin.contact-settings.index'));
        $response->assertStatus(200);
        $response->assertSee('Default Office HQ');
        $response->assertSee('Default Headquarters');
    }

    /**
     * Test guests and non-admins are blocked from accessing contact settings.
     */
    public function test_guests_blocked_from_contact_settings(): void
    {
        // Unauthenticated
        $response = $this->get(route('admin.contact-settings.index'));
        $response->assertRedirect(route('login'));

        // Non-admin (guest user)
        $user = User::factory()->create(['status' => 'active']);
        $user->assignRole('guest');

        $response2 = $this->actingAs($user)->get(route('admin.contact-settings.index'));
        $response2->assertStatus(403);
    }

    /**
     * Test admin can update contact settings.
     */
    public function test_admin_can_update_contact_settings(): void
    {
        $admin = User::factory()->create(['status' => 'active']);
        $admin->assignRole('admin');

        Storage::fake('public');
        $file = UploadedFile::fake()->image('office.jpg');

        $response = $this->actingAs($admin)->post(route('admin.contact-settings.update'), [
            'office_title' => 'Updated Office Name',
            'address_title' => 'Updated HQ Label',
            'address_content' => '456 New Road, City',
            'phone_title' => 'Main Hotline',
            'phone_number' => '+91 11111 22222',
            'phone_hours' => '10AM - 5PM',
            'email_title' => 'Get In Touch',
            'email_support' => 'help@dockit.in',
            'email_info' => 'hello@dockit.in',
            'support_text' => 'We respond within 2 hours',
            'footer_badge' => 'DockIt Net Operations',
            'office_image' => $file,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $settings = ContactSetting::first();
        $this->assertEquals('Updated Office Name', $settings->office_title);
        $this->assertEquals('Updated HQ Label', $settings->address_title);
        $this->assertEquals('456 New Road, City', $settings->address_content);
        $this->assertEquals('+91 11111 22222', $settings->phone_number);
        $this->assertNotNull($settings->office_image);

        // Assert file exists on disk
        Storage::disk('public')->assertExists($settings->office_image);
    }

    /**
     * Test updating cover photo deletes old photo.
     */
    public function test_updating_cover_photo_deletes_old_photo_from_disk(): void
    {
        $admin = User::factory()->create(['status' => 'active']);
        $admin->assignRole('admin');

        Storage::fake('public');
        
        // Upload initial image
        $file1 = UploadedFile::fake()->image('initial.jpg');
        $path1 = $file1->store('settings', 'public');

        $settings = ContactSetting::first();
        $settings->update(['office_image' => $path1]);

        Storage::disk('public')->assertExists($path1);

        // Upload second image replacing the old one
        $file2 = UploadedFile::fake()->image('new.jpg');

        $response = $this->actingAs($admin)->post(route('admin.contact-settings.update'), [
            'office_title' => 'Office',
            'address_title' => 'HQ',
            'address_content' => 'Addr',
            'phone_title' => 'Phone',
            'phone_number' => '+91 00000 00000',
            'phone_hours' => '9-6',
            'email_title' => 'Email',
            'email_support' => 'support@dockit.in',
            'email_info' => 'info@dockit.in',
            'support_text' => 'Txt',
            'footer_badge' => 'Badge',
            'office_image' => $file2,
        ]);

        $response->assertRedirect();
        
        $settings->refresh();
        $this->assertNotEquals($path1, $settings->office_image);
        Storage::disk('public')->assertExists($settings->office_image);
        
        // Assert old photo has been deleted from disk
        Storage::disk('public')->assertMissing($path1);
    }

    /**
     * Test dynamic values are correctly rendered on the public landing page.
     */
    public function test_contact_details_render_on_landing_page(): void
    {
        $settings = ContactSetting::first();
        $settings->update([
            'office_title' => 'Visible Office Location',
            'address_content' => '123 Dynamic Street Location',
            'phone_number' => '+91 98765 43210',
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Visible Office Location');
        $response->assertSee('123 Dynamic Street Location');
        $response->assertSee('+91 98765 43210');
    }
}

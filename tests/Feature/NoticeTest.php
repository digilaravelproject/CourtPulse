<?php

namespace Tests\Feature;

use App\Models\Court;
use App\Models\Notice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class NoticeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create standard roles for authorization tests
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'guest', 'guard_name' => 'web']);
    }

    /**
     * Test public page `/latest-updates` renders notices successfully.
     */
    public function test_public_updates_page_renders_successfully(): void
    {
        $court = Court::create([
            'name' => 'High Court of Karnataka',
            'city' => 'Bengaluru',
            'area' => 'Cubbon Park',
            'pincode' => '560001',
        ]);

        Notice::create([
            'title'          => 'Circular regarding hybrid video conferencing guidelines',
            'court_id'       => $court->id,
            'pdf_path'       => 'notices/test_doc.pdf',
            'show_new_badge' => true,
        ]);

        $response = $this->get('/latest-updates');
        $response->assertStatus(200);
        $response->assertSee('Circular regarding hybrid video conferencing guidelines');
        $response->assertSee('High Court of Karnataka');
        $response->assertSee('New'); // "New" badge should be shown
    }

    /**
     * Test admin notices index page is restricted.
     */
    public function test_admin_notices_is_blocked_for_guests_and_unauthenticated(): void
    {
        $response = $this->get('/admin/notices');
        $response->assertRedirect('/login');

        $user = User::factory()->create();
        $user->assignRole('guest');

        $response = $this->actingAs($user)->get('/admin/notices');
        $response->assertStatus(403);
    }

    /**
     * Test admin notices index is accessible to admin.
     */
    public function test_admin_notices_is_accessible_to_admin(): void
    {
        $admin = User::factory()->create(['status' => 'active']);
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get('/admin/notices');
        $response->assertStatus(200);
    }

    /**
     * Test admin can create a notice.
     */
    public function test_admin_can_create_notice(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['status' => 'active']);
        $admin->assignRole('admin');

        $court = Court::create([
            'name' => 'Madras High Court',
            'city' => 'Chennai',
            'area' => 'Parrys',
            'pincode' => '600001',
        ]);

        $file = UploadedFile::fake()->create('madras_circular.pdf', 500, 'application/pdf');

        $response = $this->actingAs($admin)->postJson(route('admin.notices.store'), [
            'title'          => 'SOP for physical filings in Madurai Bench',
            'court_id'       => $court->id,
            'pdf_file'       => $file,
            'show_new_badge' => '1',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('notices', [
            'title'          => 'SOP for physical filings in Madurai Bench',
            'court_id'       => $court->id,
            'show_new_badge' => true,
        ]);

        $notice = Notice::first();
        $this->assertNotNull($notice->pdf_path);
        Storage::disk('public')->assertExists($notice->pdf_path);
    }

    /**
     * Test creating a notice without target court works (optional court).
     */
    public function test_admin_can_create_general_notice_without_court(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['status' => 'active']);
        $admin->assignRole('admin');

        $file = UploadedFile::fake()->create('general_notice.pdf', 500, 'application/pdf');

        $response = $this->actingAs($admin)->postJson(route('admin.notices.store'), [
            'title'          => 'General update regarding network maintenance',
            'pdf_file'       => $file,
            'show_new_badge' => '0',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('notices', [
            'title'          => 'General update regarding network maintenance',
            'court_id'       => null,
            'show_new_badge' => false,
        ]);
    }

    /**
     * Test notice title maximum characters validation limit (150 chars).
     */
    public function test_creating_notice_fails_if_title_exceeds_150_characters(): void
    {
        $admin = User::factory()->create(['status' => 'active']);
        $admin->assignRole('admin');

        $longTitle = str_repeat('A', 151);
        $file = UploadedFile::fake()->create('circular.pdf', 500, 'application/pdf');

        $response = $this->actingAs($admin)->postJson(route('admin.notices.store'), [
            'title'          => $longTitle,
            'pdf_file'       => $file,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['title']);
    }

    /**
     * Test updating notice details and replacing PDF file.
     */
    public function test_updating_notice_details_and_replacing_pdf(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['status' => 'active']);
        $admin->assignRole('admin');

        $notice = Notice::create([
            'title'          => 'Original Title',
            'pdf_path'       => UploadedFile::fake()->create('old_doc.pdf', 100, 'application/pdf')->store('notices', 'public'),
            'show_new_badge' => false,
        ]);
        
        $oldPath = $notice->pdf_path;
        Storage::disk('public')->assertExists($oldPath);

        $newFile = UploadedFile::fake()->create('new_doc.pdf', 200, 'application/pdf');

        $response = $this->actingAs($admin)->postJson(route('admin.notices.update', $notice->id), [
            'title'          => 'Updated Title',
            'court_id'       => '',
            'pdf_file'       => $newFile,
            'show_new_badge' => 'on',
        ]);

        $response->assertStatus(200);
        $notice->refresh();

        $this->assertEquals('Updated Title', $notice->title);
        $this->assertTrue($notice->show_new_badge);
        $this->assertNotEquals($oldPath, $notice->pdf_path);
        
        Storage::disk('public')->assertExists($notice->pdf_path);
        Storage::disk('public')->assertMissing($oldPath);
    }

    /**
     * Test admin can delete a notice.
     */
    public function test_admin_can_delete_notice(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['status' => 'active']);
        $admin->assignRole('admin');

        $filePath = UploadedFile::fake()->create('circular_to_delete.pdf', 500, 'application/pdf')->store('notices', 'public');

        $notice = Notice::create([
            'title'    => 'Temporary Notice',
            'pdf_path' => $filePath,
        ]);

        Storage::disk('public')->assertExists($filePath);

        $response = $this->actingAs($admin)->deleteJson(route('admin.notices.destroy', $notice->id));
        $response->assertStatus(200);

        $this->assertDatabaseMissing('notices', ['id' => $notice->id]);
        Storage::disk('public')->assertMissing($filePath);
    }
}

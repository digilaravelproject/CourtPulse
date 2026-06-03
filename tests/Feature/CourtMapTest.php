<?php

namespace Tests\Feature;

use App\Models\Court;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CourtMapTest extends TestCase
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
     * Test public page `/court-maps` loads successfully.
     */
    public function test_public_court_maps_page_renders_successfully(): void
    {
        $court = Court::create([
            'name' => 'Supreme Court of India',
            'city' => 'New Delhi',
            'area' => 'Tilak Marg',
            'pincode' => '110001',
        ]);

        $response = $this->get('/court-maps');
        $response->assertStatus(200);
        $response->assertSee('Supreme Court of India');
        $response->assertSee('Tilak Marg');
    }

    /**
     * Test admin maps page is blocked for guests and guests roles.
     */
    public function test_admin_court_maps_is_blocked_for_guests_and_unauthenticated(): void
    {
        $response = $this->get('/admin/court-maps');
        $response->assertRedirect('/login');

        $user = User::factory()->create();
        $user->assignRole('guest');

        $response = $this->actingAs($user)->get('/admin/court-maps');
        $response->assertStatus(403);
    }

    /**
     * Test admin maps page is accessible for admin role.
     */
    public function test_admin_court_maps_is_accessible_to_admin(): void
    {
        $admin = User::factory()->create(['status' => 'active']);
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get('/admin/court-maps');
        $response->assertStatus(200);
    }

    /**
     * Test uploading a PDF map.
     */
    public function test_admin_can_upload_pdf_court_map(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['status' => 'active']);
        $admin->assignRole('admin');

        $court = Court::create([
            'name' => 'Delhi High Court',
            'city' => 'New Delhi',
            'area' => 'Shershah Road',
            'pincode' => '110003',
        ]);

        $file = UploadedFile::fake()->create('delhi_high_court.pdf', 500, 'application/pdf');

        $response = $this->actingAs($admin)->postJson(route('admin.court-maps.upload', $court->id), [
            'map_file' => $file,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $court->refresh();
        $this->assertNotNull($court->map_path);
        Storage::disk('public')->assertExists($court->map_path);
    }

    /**
     * Test non-PDF files are rejected.
     */
    public function test_uploading_non_pdf_fails_validation(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['status' => 'active']);
        $admin->assignRole('admin');

        $court = Court::create([
            'name' => 'Bombay High Court',
            'city' => 'Mumbai',
            'area' => 'Fort',
            'pincode' => '400032',
        ]);

        $file = UploadedFile::fake()->create('bombay_court_map.jpg', 500, 'image/jpeg');

        $response = $this->actingAs($admin)->postJson(route('admin.court-maps.upload', $court->id), [
            'map_file' => $file,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['map_file']);
    }

    /**
     * Test old map is deleted from disk when new one is uploaded.
     */
    public function test_uploading_new_map_deletes_old_file_from_disk(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['status' => 'active']);
        $admin->assignRole('admin');

        $court = Court::create([
            'name' => 'Kolkata High Court',
            'city' => 'Kolkata',
            'area' => 'Esplanade',
            'pincode' => '700001',
        ]);

        // First upload
        $file1 = UploadedFile::fake()->create('map1.pdf', 500, 'application/pdf');
        $this->actingAs($admin)->postJson(route('admin.court-maps.upload', $court->id), [
            'map_file' => $file1,
        ]);

        $court->refresh();
        $firstPath = $court->map_path;
        Storage::disk('public')->assertExists($firstPath);

        // Second upload
        $file2 = UploadedFile::fake()->create('map2.pdf', 400, 'application/pdf');
        $this->actingAs($admin)->postJson(route('admin.court-maps.upload', $court->id), [
            'map_file' => $file2,
        ]);

        $court->refresh();
        $secondPath = $court->map_path;

        Storage::disk('public')->assertExists($secondPath);
        Storage::disk('public')->assertMissing($firstPath);
        $this->assertNotEquals($firstPath, $secondPath);
    }
}

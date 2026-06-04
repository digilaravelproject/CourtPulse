<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class BlogTest extends TestCase
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
     * Test public blogs listing page returns active list.
     */
    public function test_public_blogs_listing_renders_successfully(): void
    {
        Blog::create([
            'title'      => 'Dynamic E-filing Guidelines',
            'slug'       => 'dynamic-e-filing-guidelines',
            'category'   => 'Procedural Law',
            'content'    => '<p>Standard guidelines for filings.</p>',
            'image_path' => 'blogs/test.jpg',
        ]);

        $response = $this->get('/blogs');
        $response->assertStatus(200);
        $response->assertSee('Dynamic E-filing Guidelines');
        $response->assertSee('Procedural Law');
    }

    /**
     * Test public blog details page displays rich text formatting and sidebar.
     */
    public function test_public_blog_details_page_renders_successfully(): void
    {
        $blog = Blog::create([
            'title'      => 'Detailed Blog Title',
            'category'   => 'E-Committee',
            'content'    => '<h2>Sub-heading</h2><p>Safe paragraph</p><blockquote>Quote</blockquote>',
            'image_path' => 'blogs/detail.jpg',
        ]);

        $response = $this->get('/blogs/' . $blog->slug);
        $response->assertStatus(200);
        $response->assertSee('Detailed Blog Title');
        $response->assertSee('Sub-heading');
        $response->assertSee('Safe paragraph');
        $response->assertSee('Quote');
    }

    /**
     * Test guest and unauthorized users are blocked from admin blog CRUD endpoints.
     */
    public function test_admin_blogs_is_restricted_for_unauthorized_users(): void
    {
        // Unauthenticated
        $response = $this->get('/admin/blogs');
        $response->assertRedirect('/login');

        // Authenticated as guest role
        $user = User::factory()->create();
        $user->assignRole('guest');

        $response = $this->actingAs($user)->get('/admin/blogs');
        $response->assertStatus(403);
    }

    /**
     * Test admin can view list and write forms.
     */
    public function test_admin_can_access_blog_index_and_create_pages(): void
    {
        $admin = User::factory()->create(['status' => 'active']);
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get('/admin/blogs');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get('/admin/blogs/create');
        $response->assertStatus(200);
    }

    /**
     * Test admin can create a blog post with image upload and rich text sanitization.
     */
    public function test_admin_can_create_blog_post(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['status' => 'active']);
        $admin->assignRole('admin');

        $file = UploadedFile::fake()->image('cover.webp');

        $response = $this->actingAs($admin)->post(route('admin.blogs.store'), [
            'title'    => 'New Legal Tech Solutions',
            'category' => 'Technology',
            'content'  => '<p>Formatted content</p><script>alert("XSS")</script>',
            'image'    => $file,
        ]);

        $response->assertRedirect(route('admin.blogs.index'));

        // Assert database records and slug auto-generation
        $this->assertDatabaseHas('blogs', [
            'title'    => 'New Legal Tech Solutions',
            'slug'     => 'new-legal-tech-solutions',
            'category' => 'Technology',
        ]);

        $blog = Blog::first();
        $this->assertNotNull($blog->image_path);
        Storage::disk('public')->assertExists($blog->image_path);

        // Assert content is sanitized
        $this->assertStringContainsString('<p>Formatted content</p>', $blog->content);
        $this->assertStringNotContainsString('<script>', $blog->content);
    }

    /**
     * Test blog validation constraints.
     */
    public function test_creating_blog_fails_on_validation_errors(): void
    {
        $admin = User::factory()->create(['status' => 'active']);
        $admin->assignRole('admin');

        // Invalid title (empty), invalid content (too short), and no image
        $response = $this->actingAs($admin)->post(route('admin.blogs.store'), [
            'title'    => '',
            'category' => 'General',
            'content'  => 'Short',
        ]);

        $response->assertSessionHasErrors(['title', 'content', 'image']);
    }

    /**
     * Test admin can edit and update a blog post details and replace cover image.
     */
    public function test_admin_can_update_blog_details_and_image(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['status' => 'active']);
        $admin->assignRole('admin');

        $oldImage = UploadedFile::fake()->image('old_thumb.png')->store('blogs', 'public');
        
        $blog = Blog::create([
            'title'      => 'Old Title',
            'slug'       => 'old-title',
            'category'   => 'Old Category',
            'content'    => '<p>Original body text</p>',
            'image_path' => $oldImage,
        ]);

        Storage::disk('public')->assertExists($oldImage);

        $newImage = UploadedFile::fake()->image('new_thumb.jpg');

        $response = $this->actingAs($admin)->post(route('admin.blogs.update', $blog->id), [
            'title'    => 'Newly Updated Title',
            'category' => 'Updated Category',
            'content'  => '<p>New body content paragraphs</p>',
            'image'    => $newImage,
        ]);

        $response->assertRedirect(route('admin.blogs.index'));
        $blog->refresh();

        $this->assertEquals('Newly Updated Title', $blog->title);
        $this->assertEquals('newly-updated-title', $blog->slug);
        $this->assertEquals('Updated Category', $blog->category);
        $this->assertEquals('<p>New body content paragraphs</p>', $blog->content);
        
        // Assert old image is deleted and new image is stored
        Storage::disk('public')->assertMissing($oldImage);
        Storage::disk('public')->assertExists($blog->image_path);
    }

    /**
     * Test admin can delete a blog post.
     */
    public function test_admin_can_delete_blog_post(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['status' => 'active']);
        $admin->assignRole('admin');

        $imagePath = UploadedFile::fake()->image('delete_me.webp')->store('blogs', 'public');

        $blog = Blog::create([
            'title'      => 'Delete Me',
            'slug'       => 'delete-me',
            'content'    => '<p>Content</p>',
            'image_path' => $imagePath,
        ]);

        Storage::disk('public')->assertExists($imagePath);

        $response = $this->actingAs($admin)->deleteJson(route('admin.blogs.destroy', $blog->id));
        $response->assertStatus(200);

        $this->assertDatabaseMissing('blogs', ['id' => $blog->id]);
        Storage::disk('public')->assertMissing($imagePath);
    }
}

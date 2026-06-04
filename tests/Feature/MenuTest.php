<?php

namespace Tests\Feature;

use App\Models\NavigationMenu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create standard roles for authorization tests
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'guest', 'guard_name' => 'web']);
    }

    /**
     * Test admin can view public menus index, but admin menus are excluded.
     */
    public function test_admin_can_view_menu_management_index_filtered_to_public(): void
    {
        $admin = User::factory()->create(['status' => 'active']);
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('admin.manage.menus'));
        $response->assertStatus(200);
        
        // Assert public menus are in the viewData
        $menus = $response->viewData('menus');
        $this->assertNotNull($menus);
        $this->assertGreaterThan(0, $menus->count());

        $hasHome = false;
        $hasSearch = false;
        foreach ($menus as $m) {
            if ($m->key === 'home') $hasHome = true;
            if ($m->key === 'search') $hasSearch = true;
            // Assert no admin menus are in the viewData
            $this->assertEquals('public', $m->type);
            $this->assertNotEquals('Dashboard', $m->label);
        }
        $this->assertTrue($hasHome);
        $this->assertTrue($hasSearch);
    }

    /**
     * Test admin can update menu visibility.
     */
    public function test_admin_can_update_menu_visibility(): void
    {
        $admin = User::factory()->create(['status' => 'active']);
        $admin->assignRole('admin');

        $menu = NavigationMenu::where('key', 'search')->first();
        $this->assertTrue($menu->is_visible);

        // Update to hidden
        $response = $this->actingAs($admin)->patchJson(route('admin.manage.menus.update', $menu->id), [
            'label' => 'Search New Label',
            'is_visible' => 0
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $menu->refresh();
        $this->assertEquals('Search New Label', $menu->label);
        $this->assertFalse($menu->is_visible);
    }

    /**
     * Test that updating visibility reflects on the public pages.
     */
    public function test_menu_visibility_updates_reflect_on_public_home_page(): void
    {
        // View home page initially - search should be visible
        $response = $this->get('/');
        $response->assertStatus(200);
        
        // Assert we see the search menu link in layout navigation
        $response->assertSee('class="text-xs font-bold text-slate-400 hover:text-white transition-colors no-underline tracking-[0.15em] uppercase hover:shadow-[0_2px_0_0_#B4B4FE] pb-1">Search</a>', false);

        // Turn search visibility off
        $searchMenu = NavigationMenu::where('key', 'search')->first();
        $searchMenu->update(['is_visible' => false]);

        // View home page again - search should not be visible anymore
        $response2 = $this->get('/');
        $response2->assertStatus(200);
        
        // Assert we do not see the search menu link or search icon
        $response2->assertDontSee('class="text-xs font-bold text-slate-400 hover:text-white transition-colors no-underline tracking-[0.15em] uppercase hover:shadow-[0_2px_0_0_#B4B4FE] pb-1">Search</a>', false);
        $response2->assertDontSee('bi-search');
    }
}

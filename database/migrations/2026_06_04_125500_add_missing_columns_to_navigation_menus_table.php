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
        // Add missing columns if they do not exist already
        Schema::table('navigation_menus', function (Blueprint $table) {
            if (!Schema::hasColumn('navigation_menus', 'type')) {
                $table->string('type')->default('public');
            }
            if (!Schema::hasColumn('navigation_menus', 'icon')) {
                $table->string('icon')->nullable();
            }
            if (!Schema::hasColumn('navigation_menus', 'route')) {
                $table->string('route')->nullable();
            }
        });

        // Truncate and seed the exact menu items
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('navigation_menus')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('navigation_menus')->insert([
            ['key' => 'home', 'label' => 'Home', 'type' => 'public', 'icon' => null, 'route' => null, 'is_visible' => true, 'order' => 1],
            ['key' => 'how-it-works', 'label' => 'How it works', 'type' => 'public', 'icon' => null, 'route' => null, 'is_visible' => true, 'order' => 2],
            ['key' => 'search', 'label' => 'Search', 'type' => 'public', 'icon' => null, 'route' => null, 'is_visible' => true, 'order' => 3],
            ['key' => 'blogs', 'label' => 'Blogs', 'type' => 'public', 'icon' => null, 'route' => null, 'is_visible' => true, 'order' => 4],
            ['key' => 'updates', 'label' => 'Updates', 'type' => 'public', 'icon' => null, 'route' => null, 'is_visible' => true, 'order' => 5],
            ['key' => 'contact', 'label' => 'Contact', 'type' => 'public', 'icon' => null, 'route' => null, 'is_visible' => true, 'order' => 6],
            
            // Admin menus
            ['key' => 'admin_dashboard', 'label' => 'Dashboard', 'type' => 'admin', 'icon' => 'bi-grid-1x2-fill', 'route' => 'admin.dashboard', 'is_visible' => true, 'order' => 1],
            ['key' => 'admin_users_support', 'label' => 'Support Staff', 'type' => 'admin', 'icon' => 'bi-shield-check', 'route' => 'admin.manage.users', 'is_visible' => true, 'order' => 2],
            ['key' => 'admin_users_professionals', 'label' => 'Professionals', 'type' => 'admin', 'icon' => 'bi-briefcase-fill', 'route' => 'admin.manage.users', 'is_visible' => true, 'order' => 3],
            ['key' => 'admin_users_guests', 'label' => 'Guest Users', 'type' => 'admin', 'icon' => 'bi-people-fill', 'route' => 'admin.manage.users', 'is_visible' => true, 'order' => 4],
            ['key' => 'admin_courts', 'label' => 'Courts Data', 'type' => 'admin', 'icon' => 'bi-buildings-fill', 'route' => 'admin.courts.index', 'is_visible' => true, 'order' => 5],
            ['key' => 'admin_menus', 'label' => 'Menu Management', 'type' => 'admin', 'icon' => 'bi-list-ul', 'route' => 'admin.manage.menus', 'is_visible' => true, 'order' => 6],
            ['key' => 'admin_feedback', 'label' => 'Feedback', 'type' => 'admin', 'icon' => 'bi-star-fill', 'route' => 'admin.feedback', 'is_visible' => true, 'order' => 7],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('navigation_menus', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('navigation_menus', 'type')) {
                $columns[] = 'type';
            }
            if (Schema::hasColumn('navigation_menus', 'icon')) {
                $columns[] = 'icon';
            }
            if (Schema::hasColumn('navigation_menus', 'route')) {
                $columns[] = 'route';
            }
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};

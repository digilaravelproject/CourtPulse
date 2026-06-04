<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetMenus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menu:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset and seed the navigation menus table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Resetting navigation menus...');

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

        $this->info('Navigation menus successfully reset and seeded!');
    }
}

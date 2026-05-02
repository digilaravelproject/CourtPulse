<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\NavigationMenu;

$adminMenus = [
    [
        'key' => 'admin_dashboard',
        'label' => 'Dashboard',
        'route' => 'admin.dashboard',
        'type' => 'admin',
        'icon' => 'bi-grid-1x2-fill',
        'is_visible' => true,
        'order' => 1
    ],
    [
        'key' => 'admin_users_support',
        'label' => 'Support Staff',
        'route' => 'admin.manage.users',
        'type' => 'admin',
        'icon' => 'bi-shield-check',
        'is_visible' => true,
        'order' => 2
    ],
    [
        'key' => 'admin_users_professionals',
        'label' => 'Professionals',
        'route' => 'admin.manage.users',
        'type' => 'admin',
        'icon' => 'bi-briefcase-fill',
        'is_visible' => true,
        'order' => 3
    ],
    [
        'key' => 'admin_users_guests',
        'label' => 'Guest Users',
        'route' => 'admin.manage.users',
        'type' => 'admin',
        'icon' => 'bi-people-fill',
        'is_visible' => true,
        'order' => 4
    ],
    [
        'key' => 'admin_courts',
        'label' => 'Courts Data',
        'route' => 'admin.courts.index',
        'type' => 'admin',
        'icon' => 'bi-buildings-fill',
        'is_visible' => true,
        'order' => 5
    ],
    [
        'key' => 'admin_menus',
        'label' => 'Menu Management',
        'route' => 'admin.manage.menus',
        'type' => 'admin',
        'icon' => 'bi-list-ul',
        'is_visible' => true,
        'order' => 6
    ],
    [
        'key' => 'admin_feedback',
        'label' => 'Feedback',
        'route' => 'admin.feedback',
        'type' => 'admin',
        'icon' => 'bi-star-fill',
        'is_visible' => true,
        'order' => 7
    ],
];

foreach ($adminMenus as $menu) {
    NavigationMenu::updateOrCreate(['key' => $menu['key']], $menu);
}

echo "Admin menus seeded successfully.\n";

<?php

namespace App\Repositories;

use App\Models\NavigationMenu;
use Illuminate\Database\Eloquent\Collection;

class MenuRepository
{
    /**
     * Get all navigation menus ordered by display order.
     */
    public function getAll(): Collection
    {
        return NavigationMenu::query()->orderBy('order', 'asc')->get();
    }

    /**
     * Update a menu item.
     */
    public function update(NavigationMenu $menu, array $data): NavigationMenu
    {
        $menu->update($data);
        return $menu->refresh();
    }
}

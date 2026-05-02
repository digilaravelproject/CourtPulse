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
     * Create a new menu item.
     */
    public function create(array $data): NavigationMenu
    {
        return NavigationMenu::create($data);
    }

    /**
     * Update a menu item.
     */
    public function update(NavigationMenu $menu, array $data): NavigationMenu
    {
        $menu->update($data);
        return $menu->refresh();
    }

    /**
     * Delete a menu item.
     */
    public function delete(NavigationMenu $menu): bool
    {
        return $menu->forceDelete();
    }
}

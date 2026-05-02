<?php

namespace App\Providers;

use App\Models\Document;
use App\Models\NavigationMenu;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Share pending counts to ALL admin/* views so layout always has them
        View::composer('layouts.admin', function ($view) {
            if (Auth::check()) {
                $view->with([
                    'pendingCount'          => User::query()->where('status', 'pending')->count(),
                    'pendingDocsCount'      => Document::query()->where('status', 'pending')->count(),
                    'pendingAdvocatesCount' => User::query()->where('role', 'advocate')->where('status', 'pending')->count(),
                    'pendingClerksCount'    => User::query()->where('role', 'clerk')->where('status', 'pending')->count(),
                ]);
            } else {
                $view->with(['pendingCount' => 0, 'pendingDocsCount' => 0]);
            }
        });

        // Share navigation menus to the layouts
        View::composer(['layouts.main', 'layouts.admin'], function ($view) {
            $view->with('navMenus', NavigationMenu::query()->orderBy('order', 'asc')->get()->keyBy('key'));
        });
    }
}

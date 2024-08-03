<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer(['admin.pages.capital.product.form'], function($view) {
            return $view->with(['categories' => cache('categories')]);
        });
        view()->composer(['admin.pages.role.form'], function($view) {
            $permissions = Permission::orderBy('name')->get(['id','name'])->pluck('name','id');
            return $view->with(compact('permissions'));
        });
    }
}

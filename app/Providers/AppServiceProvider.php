<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Statamic\Statamic;
use Statamic\Facades\CP\Nav;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Statamic::script('app', 'cp');
        // Statamic::style('app', 'cp');

        Nav::extend(function ($nav) {
            $nav->content('Collections')    ->name('Entries');
            $nav->content('Navigation')     ->name('Menus');
            $nav->content('Taxonomies')     ->name('Categories');
            $nav->content('Assets')         ->name('Uploads');
            $nav->content('Globals')        ->name('Settings');
        });
    }
}

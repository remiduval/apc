<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Statamic\Facades\Utility;
use App\Http\Controllers\ExportController;

class ExportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Utility::make('export')
        ->icon('list')
        ->title('Export orders')
        ->navTitle('Export')
        ->description('Export orders to csv')
        ->routes(function ($router) {
            $router->post('/', [ExportController::class, 'download'])->name('download');
        })
        ->view('cp.export')
        ->register();
    }
}
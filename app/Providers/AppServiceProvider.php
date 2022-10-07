<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Statamic\Facades\CP\Nav;
use Statamic\Statamic;

// use DoubleThreeDigital\SimpleCommerce\SimpleCommerce;
// use DoubleThreeDigital\SimpleCommerce\Contracts\Order;
// use DoubleThreeDigital\SimpleCommerce\Contracts\Product;

use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Bridge\Sendinblue\Transport\SendinblueTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;

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
            $nav->content('Collections')->name('Entries');
            $nav->content('Navigation')->name('Menus');
            $nav->content('Taxonomies')->name('Categories');
            $nav->content('Assets')->name('Uploads');
            $nav->content('Globals')->name('Settings');
        });

        // SimpleCommerce::productPriceHook(function (Order $order, Product $product) {
        // 	if ( !empty($product->data['open_price']) ) {
        // 		foreach ( $order->data['items'] as $item) {
        // 			if ($item['product'] == $product->id) {
        // 				return $item['metadata']['amount'] * 100;
        // 			}
        // 		}
        // 	} else {
        // 		return $product->get('price');
        // 	}
        // });

        Mail::extend('sendinblue', function () {
            return (new SendinblueTransportFactory)->create(
                new Dsn(
                    'sendinblue+api',
                    'default',
                    config('services.sendinblue.key')
                )
            );
        });
    }
}


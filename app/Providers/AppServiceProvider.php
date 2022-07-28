<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Statamic\Statamic;
use Statamic\Facades\CP\Nav;

// use DoubleThreeDigital\SimpleCommerce\SimpleCommerce;
// use DoubleThreeDigital\SimpleCommerce\Contracts\Order;
// use DoubleThreeDigital\SimpleCommerce\Contracts\Product;

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

		// Nav::extend(function ($nav) {
		// 	$nav->content('Collections')    ->name('Entries');
		// 	$nav->content('Navigation')     ->name('Menus');
		// 	$nav->content('Taxonomies')     ->name('Categories');
		// 	$nav->content('Assets')         ->name('Uploads');
		// 	$nav->content('Globals')        ->name('Settings');
		// });

		 
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
	}
}

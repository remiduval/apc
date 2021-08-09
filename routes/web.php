<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

if (App::environment('production')) {
	URL::forceScheme('https');
}

$accepted_languages = ['fr', 'en'];
$browser_language = 'fr';
if ( isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ) {
	$browser_language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
}

if ( in_array ( $browser_language, $accepted_languages ) ) {
	Route::redirect('/', $browser_language);
} else {
	Route::redirect('/', '/fr');
}

Route::statamic('/sitemap.xml', 'sitemap/sitemap', [
	'layout' => null, 
	'content_type' => 'application/xml'
]); 


// Route::statamic('/en/services/classifieds/topics/{topic}',		'templates.classifieds');
// Route::statamic('/fr/services/petites-annonces/topics/{topic}',	'templates.classifieds');
Route::redirect('/en/topics/{topic}', '/en/services/classifieds/topics/{topic}');
Route::redirect('/fr/topics/{topic}', '/fr/services/petites-annonces/topics/{topic}');



Route::statamic('/cart',					'checkout.templates.cart',			['title' => 'Your Cart']);
Route::statamic('/checkout/information',	'checkout.templates.information',	['title' => 'Checkout - Information']);
Route::statamic('/checkout/shipping',		'checkout.templates.shipping',		['title' => 'Checkout - Shipping']);
Route::statamic('/checkout/payment',		'checkout.templates.payment',		['title' => 'Checkout - Payment']);
Route::statamic('/checkout/complete',		'checkout.templates.complete',		['title' => 'Checkout - Complete']);
Route::redirect('/checkout', '/checkout/information');

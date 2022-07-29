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
Route::redirect('/en/topics/{topic}', '/en/our-actions/classifieds/topics/{topic}');
Route::redirect('/fr/topics/{topic}', '/fr/nos-actions/petites-annonces/topics/{topic}');



// Route::statamic('/cart',					'checkout.templates.cart',			['title' => 'Your Cart']);
// Route::statamic('/checkout/information',	'checkout.templates.information',	['title' => 'Checkout - Information']);
// Route::statamic('/checkout/shipping',		'checkout.templates.shipping',		['title' => 'Checkout - Note']);
// Route::statamic('/checkout/payment',		'checkout.templates.payment',		['title' => 'Checkout - Payment']);
// Route::statamic('/checkout/complete',		'checkout.templates.complete',		['title' => 'Checkout - Complete']);
// Route::redirect('/checkout', '/checkout/information');

Route::statamic('/reset-password',		'templates.reset',		['title' => 'Password reset']);



// UNCOMMENT TO TEST EMAIL
// use DoubleThreeDigital\SimpleCommerce\Facades\Order;
// use DoubleThreeDigital\SimpleCommerce\Facades\Currency;
// use Illuminate\Bus\Queueable;
// use Illuminate\Notifications\Messages\MailMessage;
// use App\Notifications\CustomerOrderPaidCustom;
// use Statamic\Facades\Site;

// Route::get('/notification', function () {
//     $order = Order::find('ac13c3e8-dde9-44b1-b972-577f518368a7');

//     return (new CustomerOrderPaidCustom($order))
//                 ->toMail($order);

// });
<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Sites
	|--------------------------------------------------------------------------
	|
	| For each of your Statamic sites, you can setup a new store which allows you
	| to use different currencies, tax rates and shipping methods.
	|
	*/

	'sites' => [
		'english' => [
			'currency' => 'GBP',

			'tax' => [
				'rate'               => 0,
				'included_in_prices' => true,
			],

			'shipping' => [
				'methods' => [
					//\DoubleThreeDigital\SimpleCommerce\Shipping\StandardPost::class,
				],
			],
		],

		'french' => [
			'currency' => 'GBP',

			'tax' => [
				'rate'               => 0,
				'included_in_prices' => true,
			],

			'shipping' => [
				'methods' => [
					//\DoubleThreeDigital\SimpleCommerce\Shipping\StandardPost::class,
				],
			],
		],
	],

	/*
	|--------------------------------------------------------------------------
	| Gateways
	|--------------------------------------------------------------------------
	|
	| You can setup multiple payment gateways for your store with Simple Commerce.
	| Here's where you can configure the gateways in use.
	|
	*/

	'gateways' => [
		// \DoubleThreeDigital\SimpleCommerce\Gateways\Builtin\DummyGateway::class => [],
		\DoubleThreeDigital\SimpleCommerce\Gateways\Builtin\StripeGateway::class => [
			'key' => env('STRIPE_KEY'),
			'secret' => env('STRIPE_SECRET'),
		],
	],

	/*
	|--------------------------------------------------------------------------
	| Notifications
	|--------------------------------------------------------------------------
	|
	| Simple Commerce can automatically send notifications after events occur in your store.
	| eg. a cart being completed.
	|
	| Here's where you can toggle if certain notifications are enabled/disabled.
	|
	*/

	'notifications' => [
		'order_paid' => [
			\App\Notifications\CustomerOrderPaidCustom::class => [
				'to' => 'customer',
			],
			\DoubleThreeDigital\SimpleCommerce\Notifications\BackOfficeOrderPaid::class => [
				'to' => 'duncan@example.com',
			],
		],

		// 'order_paid' => [
		// 	\App\Notifications\CustomerOrderPaid::class => [
		// 		'to' => 'customer',
		// 	],
		// 	\App\Notifications\BackOfficeOrderPaid::class => [
		// 		'to' => env("EDITOR_EMAIL", 'contact@remiduval.com'),
		// 	],
		// ],
		'digital_download_ready' => [
			\DoubleThreeDigital\DigitalProducts\Notifications\DigitalDownloadsNotification::class => [
				'to' => 'customer',
			],
		],
	],


    /*
    |--------------------------------------------------------------------------
    | Field Whitelist
    |--------------------------------------------------------------------------
    |
    | You may configure the fields you wish to be editable via front-end forms
    | below. Wildcards are not accepted due to security concerns.
    |
    | https://simple-commerce.duncanmcclean.com/tags#field-whitelisting
    |
    */

    'field_whitelist' => [
        'orders' => [
            'shipping_name', 'shipping_address', 'shipping_address_line1', 'shipping_address_line2', 'shipping_city',
            'shipping_region', 'shipping_postal_code', 'shipping_country', 'shipping_note', 'shipping_method',
            'use_shipping_address_for_billing', 'billing_name', 'billing_address', 'billing_address_line2',
            'billing_city', 'billing_region', 'billing_postal_code', 'billing_country',
        ],

        'line_items' => [],

        'customers' => ['name', 'email'],
    ],

	/*
	|--------------------------------------------------------------------------
	| Content Drivers
	|--------------------------------------------------------------------------
	|
	| Simple Commerce stores all products, orders, coupons etc as flat-file entries.
	| This works great for store stores where you want to keep everything simple. But
	| sometimes, for more complex stores, you may want use a database instead. To do so,
	| just swap out the 'content driver' in place below.
	|
	*/

    'content' => [
        'coupons' => [
            'repository' => \DoubleThreeDigital\SimpleCommerce\Coupons\EntryCouponRepository::class,
            'collection' => 'coupons',
        ],

        'customers' => [
            'repository' => \DoubleThreeDigital\SimpleCommerce\Customers\UserCustomerRepository::class,
        ],

        'orders' => [
            'repository' => \DoubleThreeDigital\SimpleCommerce\Orders\EntryOrderRepository::class,
            'collection' => 'orders',
        ],

        'products' => [
            'repository' => \DoubleThreeDigital\SimpleCommerce\Products\EntryProductRepository::class,
            'collection' => 'products',
        ],
    ],

	/*
	|--------------------------------------------------------------------------
	| Cart
	|--------------------------------------------------------------------------
	|
	| Configure the Cart Driver in use on your site. It's what stores/gets the
	| Cart ID from the user's browser on every request.
	|
	*/

	'cart' => [
		'driver' => \DoubleThreeDigital\SimpleCommerce\Orders\Cart\Drivers\CookieDriver::class,
		'key' => 'simple-commerce-cart',
	],

	/*
	|--------------------------------------------------------------------------
	| Order Number
	|--------------------------------------------------------------------------
	|
	| If you want to, you can change the minimum order number for your store. This won't
	| affect past orders, just ones in the future.
	|
	*/

	'minimum_order_number' => 0,

	/*
	|--------------------------------------------------------------------------
	| Stock Running Low
	|--------------------------------------------------------------------------
	|
	| Simple Commerce can be configured to emit events when stock is running low for
	| products. Here is where you can configure the threshold when we start sending
	| those notifications.
	|
	*/

	'low_stock_threshold' => 25,

    'disable_form_parameter_validation' => true,

];

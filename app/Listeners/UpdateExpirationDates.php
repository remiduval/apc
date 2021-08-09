<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use DoubleThreeDigital\SimpleCommerce\Events\OrderPaid;
use DoubleThreeDigital\SimpleCommerce\Facades\Product;
use DoubleThreeDigital\SimpleCommerce\Facades\Customer;
//use Illuminate\Support\Facades\Log;


class UpdateExpirationDates
{
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * If order contains a membership (or insurance) product, update the user membership (or insurance) expiration date with the one indicated in the product he bought
	 *
	 * @param  object  $event
	 * @return void
	 */
	public function handle(OrderPaid $event)
	{
		//Log::debug(json_encode($event));

		foreach($event->order->data['items'] as $item) {
			$product = Product::find($item['product']);

			if (isset($product->data['membership']) && isset($product->data['membership_until'])) {
				$user = Customer::find($event->order->data['customer']);
				$user->data['membership_until'] = $product->data['membership_until'];
				$user->save();
			}

			if (isset($product->data['insurance']) && isset($product->data['insurance_until'])) {
				$user = Customer::find($event->order->data['customer']);
				$user->data['insurance_until'] = $product->data['insurance_until'];
				$user->save();
			}
		}
	}
}
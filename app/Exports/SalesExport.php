<?php

namespace App\Exports;

use DoubleThreeDigital\SimpleCommerce\Facades\Order;
use DoubleThreeDigital\SimpleCommerce\Facades\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Statamic\Facades\Entry;

use Carbon\Carbon;
// use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
// use Illuminate\Http\Request;

use DoubleThreeDigital\SimpleCommerce\Facades\Currency;

class SalesExport implements FromCollection, WithMapping, WithHeadings
{
	//use AuthorizesRequests;
	protected $metadataKeys = [];


	public function __construct(string $from, string $until)
	{
		$this->from = Carbon::create($from);
		$this->until =  Carbon::create($until);
	}

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function collection()
	{
		return Entry::whereCollection('orders')
			->filter(function ($entry) {
				return $entry->get('is_paid') === true;
			})
			->filter(function ($entry) {  
				return Carbon::create($entry->get('paid_date'))->between($this->from, $this->until);
			})
			->flatMap(function ($order) {
				$lineItems = Order::find($order->id())->lineItems();

				return $lineItems->map(function ($lineItem) use ($order) {
					$order = $order->fresh();

					foreach ($lineItem as $key => $value) {
						$order->data()->put($key, $value);
					}

					// if (isset($lineItem['metadata'])) {
					// 	foreach ($lineItem['metadata'] as $key => $value) {
					// 		$this->metadataKeys[] = $key;
					// 	}
					// }

					return $order;
				});
			});
	}

	public function map($order): array
	{
		$product = Product::find($order->get('product'));
		$productVariant = null;

		if ($product->purchasableType() === 'variants' && $order->has('variant')) {
			//$productVariant = '';
			$productVariant = $product->variant(is_array($order->get('variant')) ? $order->get('variant')['variant'] : $order->get('variant'));
			$productPrice = optional($productVariant)->price();
		} else {
			$productPrice = $product->get('price');
		}

		$row = [
			$order->get('title'),
			$order->get('paid_date'),
			optional($order->augmentedValue('customer')->value())->get('name'),
			optional($order->augmentedValue('customer')->value())->email(),
			$order->get('billing_name'),
			$order->get('billing_address') ?? $order->get('billing_address_line1'),
			$order->get('billing_zip_code') ?? $order->get('billing_postal_code'),
			$order->get('billing_city'),
			$order->get('billing_country'),
			$order->get('note'),
			$order->get('product'),
			$product->title(),
			optional($productVariant)->name() ?? '',
			$order->get('quantity'),
			(float) Currency::toDecimal( ($productPrice ?? 0) * $order->get('quantity') )
		];



// 		$rowMetadata = collect($this->metadataKeys)
// 			->map(function ($key) use ($order) {
// 				if (isset($order->get('metadata')[$key])) {
// 					return $order->get('metadata')[$key];
// 				}
// 				return '';
// 			})
// 			->toArray();

		return array_merge( $row, $order->get('metadata'));		
	}

	public function headings(): array
	{
		return [
			'ID',
			'Date',
			'Name',
			'Email',
			'Billing Name',
			'Address',
			'Postcode',
			'City',
			'Country',
			'Note',
			'Product ID',
			'Product Name',
			'Variant',
			'Quantity',
			'Total',
		];

		// $metadataHeadings = collect($this->metadataKeys)
		//     ->map(function ($key) {
		//         return 'Metadata: ' . $key;
		//     })
		//     ->toArray();

		// return array_merge($headings, $metadataHeadings);
	}
}
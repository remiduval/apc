<?php

namespace App\Notifications;

use DoubleThreeDigital\SimpleCommerce\Contracts\Order;
use DoubleThreeDigital\SimpleCommerce\Facades\Product;
use DoubleThreeDigital\SimpleCommerce\Facades\Currency;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Statamic\Facades\Site;
use Statamic\Entries\Entry;

class BackOfficeOrderPaid extends Notification
{
	use Queueable;

	protected $order;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct(Order $order)
	{
		$this->order = $order;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function via($notifiable)
	{
		return [
			'mail',
		];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable)
	{
		$items = $this->order->lineItems();
		$message = (new MailMessage)
			->subject("New Order: {$this->order->title()}")
			->line("Order **{$this->order->title()}** has just been paid and is ready for fulfilment.")
			->line("# Items");

			foreach ($this->order->lineItems() as $item) {
				$product_name = Product::find($item['product'])->title;
				$message->line("{$item['quantity']}x {$product_name}");
			}

		$message
			->line("# Order Details")
			->line("Total: " . Currency::parse($this->order->get('grand_total'), Site::current()))
			->line("Customer: " . optional($this->order->customer())->email() ?? 'Guest')
			->line("Payment Gateway: " . optional($this->order->gateway())['display'] ?? 'N/A');

		$message
			->action( "Review order", Entry::find($this->order->id)->editUrl() );

		return $message;
	}
}

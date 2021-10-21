<?php

namespace App\Notifications;

use DoubleThreeDigital\SimpleCommerce\Contracts\Order;
use DoubleThreeDigital\SimpleCommerce\Facades\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Barryvdh\DomPDF\Facade as PDF;

class CustomerOrderPaid extends Notification
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
		$pdf = PDF::loadView('simple-commerce::receipt', $this->order->toAugmentedArray());
			
		$message = (new MailMessage)
			->subject("Thanks for your order!")
			->line("Thanks for your order! Your order receipt has been attached to this email.")
			->line("Please get in touch if you have any questions.")
			->line("# Items");
	
		foreach ($this->order->lineItems() as $item) {
			$product = Product::find($item['product']);

			$message->line("## {$product->title}");
			$message->line("Quantity: {$item['quantity']}");

			if ( isset($product->data['instructions']) ) {
				$message->line("⚠️ {$product->data['instructions']}");
			}
		}

		$message->attachData(
			$pdf->output(),
			'receipt.pdf',
			['mime' => 'application/pdf']
		);

		return $message;
	}
}

<?php

namespace App\Listeners;

use DoubleThreeDigital\GuestEntries\Events\GuestEntryCreated;
use Statamic\Facades\Entry;
use App\Mail\NewSubmission;

use Illuminate\Support\Facades\Mail;

class SendNotificationEmailNewSubmission
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
	 *
	 * @param  object  $event
	 * @return void
	 */
	public function handle(GuestEntryCreated $event)
	{
		$entry_en = $event->entry;

		Mail::to( env("DEFAULT_EDITOR_EMAIL") )
			->send(new NewSubmission($entry_en));
	}
}
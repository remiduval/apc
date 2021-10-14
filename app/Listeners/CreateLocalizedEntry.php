<?php

namespace App\Listeners;

use DoubleThreeDigital\GuestEntries\Events\GuestEntryCreated;
use Statamic\Facades\Entry;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CreateLocalizedEntry
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

		// Creating the localized version
		$entry_fr = $entry_en->makeLocalization('french');

		// Unpublish, generate a unique slug, set data
		$entry_fr
			->published(false)
			->slug( $this->generateSlug('classifieds', $entry_en->title_fr) )
			->data([
				'title' => $entry_en->title_fr,
				'prose' => $entry_en->prose_fr,
			])
			->save();

		// Converting date input to Y-m-d format
		$expiration_date = Carbon::parse($entry_en->expiration)->format('Y-m-d');
		$entry_en
			->set('publish_date', Carbon::now()->format('Y-m-d'))
			->set('expiration', $expiration_date)
			->save();

		// Clearing French data on origin entry
		$entry_en
			->set('title_fr', '')
			->set('prose_fr', '')

			->save();
	}


    /**
     * Generate a unique slug
     * it checks if the slug exists on the collection
     * if not then return the slug
     *
     * @param string $collection
     * @param $slug
     * @param string $seperator
     * @param int $start_number
     *
     * @return string
     */
    public static function generateSlug(string $collection, $slug, $seperator = '-', $start_number = 1): string
    {
        $slug = \Str::slug($slug, '-');

        if (Entry::query()->where('collection', $collection)->where('slug', $slug)->first()) {
            $baseSlug = $slug;
            do {
                $slug = $baseSlug.$seperator.$start_number;
                $start_number++;
            } while (Entry::query()->where('collection', $collection)->where('slug', $slug)->first());
        }

        return $slug;
    }
}
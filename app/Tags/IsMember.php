<?php

namespace App\Tags;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Statamic\Tags\Tags;

class IsMember extends Tags
{
	/**
	 * The {{ is_member }} tag.
	 *
	 * @return string|array
	 */
	public function index()
	{
		$user = Auth::user();

		if ($user && $user->membership_until) {
			return Carbon::createFromFormat('Y-m-d', $user->membership_until)->isFuture();
		} else {
			return false;
		}
	}
}

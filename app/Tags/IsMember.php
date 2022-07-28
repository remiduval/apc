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
			$carbon_membership_until = new Carbon($user->membership_until);
			return $carbon_membership_until->isFuture();
			//return Carbon::createFromFormat('Y-m-d', $user->membership_until)->isFuture();
		} else {
			return false;
		}
	}
}

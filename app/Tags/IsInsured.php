<?php

namespace App\Tags;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Statamic\Tags\Tags;

class IsInsured extends Tags
{
	/**
	 * The {{ is_insured }} tag.
	 *
	 * @return string|array
	 */
	public function index()
	{
		$user = Auth::user();

		if ($user && $user->insurance_until) {
			$carbon_insurance_until = new Carbon($user->insurance_until);
			return $carbon_insurance_until->isFuture();
			//return Carbon::createFromFormat('Y-m-d', $user->insurance_until)->isFuture();
		} else {
			return false;
		}
	}
}

<?php

namespace App\Tags;
use Carbon\Carbon;

use Statamic\Tags\Tags;

class SchoolYear extends Tags
{

	public function start()
	{
        return 'test';
        return Carbon::now()->format('Y-08-01');
	}

	public function end()
	{
        $now = Carbon::now();
        $now2 = $now->copy()->addYears(1);
        return $now2->format('Y-07-31');
	}
}

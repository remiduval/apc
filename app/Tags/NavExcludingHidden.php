<?php

namespace App\Tags;

use Statamic\Fields\Value;
use Statamic\Support\Arr;
use Statamic\Tags\Nav;

class NavExcludingHidden extends Nav
{
    public function index()
    {
        return $this->filterOutHidden(parent::index());
    }

    private function filterOutHidden($pages)
    {
        return collect($pages)->reject(function ($page) {
            $hidden = Arr::get($page, 'is_hidden');
            return $hidden instanceof Value ? $hidden->value() : $hidden;
        })->map(function ($page) {
            $page['children'] = $this->filterOutHidden($page['children']);
            return $page;
        })->all();
    }
}

?>
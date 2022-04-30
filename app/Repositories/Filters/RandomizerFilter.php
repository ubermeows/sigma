<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Abstracts\AbstractFilter;

class RandomizerFilter extends AbstractFilter
{
    public function apply(Builder $builder): void
    {
        $builder->when($this->request->get('random'), function ($builder) {
			$builder->inRandomOrder();
        });
    }
}
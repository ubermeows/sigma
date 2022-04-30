<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Abstracts\AbstractFilter;

class StatesFilter extends AbstractFilter
{
    public function apply(Builder $builder): void
    {
        $builder->when($this->request->filled('states'), function ($builder) {

            $states = $this->request->get('states');

            $builder->whereIn('state', $states);
        });
    }
}

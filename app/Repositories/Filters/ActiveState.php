<?php

namespace App\Repositories\Filters;

use App\Enums\ClipStates;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Abstracts\AbstractFilter;

class ActiveState extends AbstractFilter
{
    public function apply(Builder $builder): void
    {
        $builder->where('state', ClipStates::Active);
    }
}

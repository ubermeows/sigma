<?php

namespace App\Repositories\Filters;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Abstracts\AbstractFilter;

class LoadRelationsFilter extends AbstractFilter
{
    public function apply(Builder $builder): void
    {
        $builder->when($this->request->filled('relations'), function ($builder) {

            $relations = $this->request->get('relations');

            $builder->with( ... $relations);
        });
    }
}

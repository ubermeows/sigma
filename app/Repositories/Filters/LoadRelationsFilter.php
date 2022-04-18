<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Abstracts\AbstractFilter;

class LoadRelationsFilter extends AbstractFilter
{
    public function isApplicable(): bool
    {
        return isset($this->arguments['relations']);
    }

    public function apply(Builder $builder): void
    {
        $relations = $this->arguments['relations'];

        $builder->with( ... $relations);
    }
}
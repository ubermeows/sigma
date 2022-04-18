<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Abstracts\AbstractFilter;

class RandomizerFilter extends AbstractFilter
{
    public function isApplicable(): bool
    {
        return isset($this->arguments['random']);
    }

    public function apply(Builder $builder): void
    {
        $builder->inRandomOrder();
    }
}
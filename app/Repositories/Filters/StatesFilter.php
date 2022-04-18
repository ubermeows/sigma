<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Abstracts\AbstractFilter;

class StatesFilter extends AbstractFilter
{
    public function isApplicable(): bool
    {
        return isset($this->arguments['states']);
    }

    public function apply(Builder $builder): void
    {
        $states = $this->arguments['states'];

        $method = is_array($states) ? 'whereIn' : 'where';

        $builder->{$method}('state', $states);
    }
}
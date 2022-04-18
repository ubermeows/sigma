<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Abstracts\AbstractFilter;

class AfterDateFilter extends AbstractFilter
{
    public function isApplicable(): bool
    {
        return isset($this->arguments['after_date']);
    }

    public function apply(Builder $builder): void
    {
        $afterDate = $this->arguments['after_date'];

        $builder->where('published_at', '>=', $afterDate);
    }
}
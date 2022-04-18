<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Abstracts\AbstractFilter;

class BeforeDateFilter extends AbstractFilter
{
    public function isApplicable(): bool
    {
        return isset($this->arguments['before_date']);
    }

    public function apply(Builder $builder): void
    {
        $beforeDate = $this->arguments['before_date'];

        $builder->where('published_at', '<=', $beforeDate);
    }
}
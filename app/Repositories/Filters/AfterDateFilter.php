<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Abstracts\AbstractFilter;

class AfterDateFilter extends AbstractFilter
{
    public function apply(Builder $builder): void
    {
        $builder->when($this->request->has('after_date'), function ($builder) {

            $afterDate = $this->request->get('after_date');

            $builder->where('published_at', '>=', $afterDate);
        });
    }
}

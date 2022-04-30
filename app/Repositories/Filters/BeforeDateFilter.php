<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Abstracts\AbstractFilter;

class BeforeDateFilter extends AbstractFilter
{
    public function apply(Builder $builder): void
    {
        $builder->when($this->request->has('before_date'), function ($builder) {

            $beforeDate = $this->request->get('before_date');

            $builder->where('published_at', '<=', $beforeDate);
        });
    }
}

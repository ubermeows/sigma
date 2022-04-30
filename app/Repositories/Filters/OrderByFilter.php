<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Abstracts\AbstractFilter;

class OrderByFilter extends AbstractFilter
{
    public function apply(Builder $builder): void
    {
        $builder->when($this->request->filled(['sort', 'order']), function ($builder) {

            $attributes = $this->request->only('sort', 'order');

            $builder->orderBy(
                column: $attributes['sort'], 
                direction: $attributes['order'],
            );
        });
    }
}

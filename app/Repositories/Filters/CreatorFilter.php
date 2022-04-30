<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Abstracts\AbstractFilter;

class CreatorFilter extends AbstractFilter
{
    public function apply(Builder $builder): void
    {
        $builder->when($this->request->filled('creator'), function ($builder) {

            $hook = $this->request->get('creator');

            $builder->where('creator_id', $creator)
                ->orWhereHas('creator', function ($query) use ($creator) {
                    return $query
                        ->where('tracking_id', $creator)
                        ->orWhere('slug', $creator);
                });
        });
    }
}

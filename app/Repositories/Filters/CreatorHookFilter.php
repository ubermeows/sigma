<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Abstracts\AbstractFilter;

class CreatorHookFilter extends AbstractFilter
{
    public function apply(Builder $builder): void
    {
        $builder->when($this->request->filled('creator'), function ($builder) {

            $hook = $this->request->get('creator');

            $builder->where('creator_id', $hook)
                ->orWhereHas('creator', function ($query) use ($hook) {
                    return $query
                        ->where('tracking_id', $hook)
                        ->orWhere('slug', $hook);
                });
        });
    }
}

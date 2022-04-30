<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Abstracts\AbstractFilter;

class EventFilter extends AbstractFilter
{
    public function apply(Builder $builder): void
    {
        $builder->when($this->request->filled('event'), function ($builder) {

            $hook = $this->request->get('event');

            $builder->where('event_id', $hook)
                ->orWhereHas('event', function ($query) use ($hook) {
                    return $query->where('slug', $hook);
                });
        });
    }
}

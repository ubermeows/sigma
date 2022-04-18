<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Abstracts\AbstractFilter;

class EventFilter extends AbstractFilter
{
    public function isApplicable(): bool
    {
        return isset($this->arguments['event']);
    }

    public function apply(Builder $builder): void
    {
    	$hook = $this->arguments['event'];

        $builder->where('event_id', $hook)
            ->orWhereHas('event', function ($query) use ($hook) {
                return $query->where('slug', $hook);
            });
    }
}
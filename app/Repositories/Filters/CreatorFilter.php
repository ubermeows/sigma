<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Abstracts\AbstractFilter;

class CreatorFilter extends AbstractFilter
{
    public function isApplicable(): bool
    {
        return isset($this->arguments['creator']);
    }

    public function apply(Builder $builder): void
    {
        $creator = $this->arguments['creator'];

        $builder->where('creator_id', $creator)
            ->orWhereHas('creator', function ($query) use ($creator) {
                return $query
                    ->where('tracking_id', $creator)
                    ->orWhere('slug', $creator);
            });
    }
}
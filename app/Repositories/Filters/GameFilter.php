<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Abstracts\AbstractFilter;

class GameFilter extends AbstractFilter
{
    public function isApplicable(): bool
    {
        return isset($this->arguments['game']);
    }

    public function apply(Builder $builder): void
    {
    	$hook = $this->arguments['game'];

        $builder->where('game_id', $hook)
            ->orWhereHas('game', function ($query) use ($hook) {
                return $query->where('slug', $hook);
            });
    }
}
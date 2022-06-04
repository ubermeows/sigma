<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Abstracts\AbstractFilter;

class GameHookFilter extends AbstractFilter
{
    public function apply(Builder $builder): void
    {
        $builder->when($this->request->filled('game'), function ($builder) {

            $hook = $this->request->get('game');

            $builder->where('game_id', $hook)
                ->orWhereHas('game', function ($query) use ($hook) {
                    return $query->where('slug', $hook);
                });
        });
    }
}

<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Abstracts\AbstractFilter;

class OrderByFilter extends AbstractFilter
{
    public function isApplicable(): bool
    {
    	return isset($this->arguments['sort'])
    		&& isset($this->arguments['order']);
    }

    public function apply(Builder $builder): void
    {
        $builder->orderBy(
            column: $this->arguments['sort'], 
            direction: $this->arguments['order'],
        );
    }
}
<?php

namespace App\Repositories\Abstracts;

use Illuminate\Database\Eloquent\Builder;

abstract class AbstractFilter
{
    public function __construct(
        public array $arguments = [],
    ){}

    abstract public function isApplicable(): bool;
    abstract public function apply(Builder $queryBuilder): void;
}

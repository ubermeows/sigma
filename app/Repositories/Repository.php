<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class Repository 
{
    protected Builder $builder;
    protected Request $request;
    protected array $filters = [];

    public function addBuilder(Builder $builder): self
    {
        $this->builder = $builder;

        return $this;
    }

    public function addRequest(Request $request): self
    {
        $this->request = $request;

        return $this;
    }

    public function through(array $filters): self
    {
        $this->filters = array_merge($this->filters, $filters);

        return $this;
    }

    public function then($closure): mixed
    {
        $this->applyFilters();

        return $closure($this->builder);
    }

    protected function applyFilters(): void
    {
        foreach ($this->filters as $filter) {
            (new $filter($this->request))->apply($this->builder);
        }
    }
}
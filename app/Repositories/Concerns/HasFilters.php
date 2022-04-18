<?php

namespace App\Repositories\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait HasFilters
{
    protected array $filters = [];

    public function pushFilters(array $filters): self
    {
        $this->filters = array_merge($this->filters, $filters);

        return $this;
    }

    public function pushFilter(string $filter): self
    {
        $this->filters[] = $filter;

        return $this;
    }

    public function resetFilters(): self
    {
        $this->filters = [];

        return $this;
    }

    public function applyFilters(Builder $builder, array $arguments): self
    {
        foreach ($this->filters as $filter) {

            $filterInstance = new $filter($arguments);

            if (! $filterInstance->isApplicable()) {
                continue;
            }

            $filterInstance->apply($builder);
        }

        $this->resetFilters();

        return $this;
    }
}

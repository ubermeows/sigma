<?php

namespace App\Repositories;

use App\Models\Clip;
use App\Repositories\Abstracts\AbstractRepository;

class ClipRepository extends AbstractRepository
{
    public function __construct(
        protected Clip $model,
    ){}

    public function paginate(array $arguments)
    {
        $builder = $this->model::query();

        $this->applyFilters($builder, $arguments);

        return $builder->paginate($arguments['per_page']);
    }
}

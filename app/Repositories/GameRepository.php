<?php

namespace App\Repositories;

use App\Models\Game;
use App\Repositories\Abstracts\AbstractRepository;

class GameRepository extends AbstractRepository
{
    public function __construct(
        protected Game $model,
    ){}

    public function paginate(array $arguments)
    {
        $builder = $this->model::query();

        $this->applyFilters($builder, $arguments);

        $builder->withCount('activeClips');

        return $builder->paginate($arguments['per_page']);
    }
}

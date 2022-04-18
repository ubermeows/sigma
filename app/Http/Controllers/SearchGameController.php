<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\GameRepository;
use App\Http\Requests\SearchGameRequest;
use App\Repositories\Filters\OrderByFilter;

class SearchGameController extends Controller
{
    public function __construct(
        protected GameRepository $repository,
    ){}

    public function __invoke(SearchGameRequest $request)
    {
        $items = $this->repository
            ->pushFilter(OrderByFilter::class)
            ->paginate($request->validated());

        return response()->json($items);
    }
}

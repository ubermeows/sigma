<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
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
            
        return new JsonResponse(
            data: $items,
            status: JsonResponse::HTTP_OK,
        );
    }
}

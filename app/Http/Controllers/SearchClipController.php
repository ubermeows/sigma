<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Repositories\ClipRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchClipRequest;

use App\Repositories\Filters\ {
    GameFilter,
    EventFilter,
    StatesFilter,
    CreatorFilter,
    OrderByFilter,
    AfterDateFilter,
    RandomizerFilter,
    BeforeDateFilter,
    LoadRelationsFilter,
};

class SearchClipController extends Controller
{
    public function __construct(
        protected ClipRepository $repository,
    ){}

    public function __invoke(SearchClipRequest $request)
    {
        $items = $this->repository
            ->pushFilters([
                AfterDateFilter::class,
                BeforeDateFilter::class,
                CreatorFilter::class,
                EventFilter::class,
                GameFilter::class,
                LoadRelationsFilter::class,
                OrderByFilter::class,
                RandomizerFilter::class,
                StatesFilter::class,
            ])
            ->paginate($request->validated());

        return new JsonResponse(
            data: $items,
            status: JsonResponse::HTTP_OK,
        );
    }
}

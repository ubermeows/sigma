<?php

namespace App\Http\Controllers;

use Closure;
use App\Models\Clip;
use App\Http\Requests\ApiRequest;
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
    protected $request = SearchClipRequest::class;

    protected $builder = Clip::class;

    protected $filters = [
        AfterDateFilter::class,
        BeforeDateFilter::class,
        CreatorFilter::class,
        EventFilter::class,
        GameFilter::class,
        LoadRelationsFilter::class,
        OrderByFilter::class,
        RandomizerFilter::class,
        StatesFilter::class,
    ];

    public function then(ApiRequest $request): Closure
    {
        return function ($builder) use ($request) {
            return $builder->paginate($request->per_page);
        };
    }
}

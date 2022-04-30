<?php

namespace App\Http\Controllers;

use Closure;
use App\Models\Clip;
use App\Repositories\Filters;
use App\Http\Requests\ApiRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchClipRequest;

class SearchClipController extends Controller
{
    protected $request = SearchClipRequest::class;

    protected $builder = Clip::class;

    protected $filters = [
        Filters\AfterDateFilter::class,
        Filters\BeforeDateFilter::class,
        Filters\CreatorFilter::class,
        Filters\EventFilter::class,
        Filters\GameFilter::class,
        Filters\LoadRelationsFilter::class,
        Filters\OrderByFilter::class,
        Filters\RandomizerFilter::class,
        Filters\StatesFilter::class,
    ];

    public function then(ApiRequest $request): Closure
    {
        return function ($builder) use ($request) {
            return $builder->paginate($request->per_page);
        };
    }
}

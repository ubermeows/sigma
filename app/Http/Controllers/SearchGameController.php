<?php

namespace App\Http\Controllers;

use Closure;
use App\Models\Game;
use App\Http\Requests\ApiRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchGameRequest;

use App\Repositories\Filters\ {
    OrderByFilter,
    RandomizerFilter,
};

class SearchGameController extends Controller
{
    protected $request = SearchGameRequest::class;

    protected $builder = Game::class;

    protected $filters = [
        OrderByFilter::class,
        RandomizerFilter::class,
    ];

    public function then(ApiRequest $request): Closure
    {
        return function ($builder) use ($request) {
            return $builder->paginate($request->per_page);
        };
    }
}

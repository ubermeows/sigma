<?php

namespace App\Http\Controllers;

use Closure;
use App\Models\Clip;
use App\Http\Requests\ApiRequest;
use App\Http\Controllers\Controller;
use App\Repositories\ClipRepository;
use App\Http\Requests\ShowClipRequest;
use App\Repositories\Filters\LoadRelationsFilter;

class ShowClipController extends Controller
{
    protected $request = ShowClipRequest::class;

    protected $builder = Clip::class;

    protected $filters = [
        LoadRelationsFilter::class,
    ];

    public function then(ApiRequest $request): Closure
    {
        return function ($builder) {
            return $builder->firstOrFail();
        };
    }
}

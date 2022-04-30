<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repository;
use App\Http\Requests\ApiRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Exceptions\UnexpectedApiArgumentsException;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __invoke(ApiRequest $request)
    {
        $this->requestIsValid($request);

        $items = Cache::remember($request->getRequestUri(), now()->addMinutes(10), function () use ($request) {

            return app(Repository::class)
                ->addBuilder($this->builder::query())
                ->addRequest($request)
                ->through($this->filters)
                ->then($this->then($request));
        });

        return new JsonResponse(
            data: $items,
            status: JsonResponse::HTTP_OK,
        );
    }

    protected function requestIsValid(ApiRequest $request): void
    {
        $rules = (new $this->request)->rules();

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            throw new UnexpectedApiArgumentsException($validator->errors());
        }
    }
}

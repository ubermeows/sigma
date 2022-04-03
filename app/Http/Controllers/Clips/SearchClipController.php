<?php

namespace App\Http\Controllers\Clips;

use App\Models\Clip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchClipRequest;

class SearchClipController extends Controller
{
    public function __invoke(SearchClipRequest $request)
    {
        $query = Clip::query();

        $query->when($request->relations, function ($query) use ($request) {
            $query->with( ... $request->relations);
        });

        $query->when($request->states, function ($query) use ($request) {
            
            $states = $request->states;

            $method = is_array($states) ? 'whereIn' : 'where';

            $query->{$method}('state', $states);
        });

        $items = $query->paginate();

        return response()->json($items);
    }
}

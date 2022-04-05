<?php

namespace App\Http\Controllers;

use App\Models\Clip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchClipRequest;

class SearchClipController extends Controller
{
    public function __invoke(SearchClipRequest $request)
    {
        $query = Clip::query();

        $query->when($request->random, function ($query) {
            $query->inRandomOrder();
        });

        $query->orderBy(
            column: $request->sort, 
            direction: $request->order,
        );

        $query->when($request->after_date, function ($query) use ($request) {
            $query->where('published_at', '>=', $request->after_date);
        });

        $query->when($request->before_date, function ($query) use ($request) {
            $query->where('published_at', '<=', $request->before_date);
        });

        $query->when($request->creator, function ($query) use ($request) {

            $creator = $request->creator;

            $query->where('creator_id', $creator)
                ->orWhereHas('creator', function ($query) use ($creator) {
                    return $query
                        ->where('tracking_id', $creator)
                        ->orWhere('name', $creator)
                        ->orWhere('slug', $creator);
                });
        });

        $query->when($request->relations, function ($query) use ($request) {
            $query->with( ... $request->relations);
        });

        $query->when($request->states, function ($query) use ($request) {

            $states = $request->states;

            $method = is_array($states) ? 'whereIn' : 'where';

            $query->{$method}('state', $states);
        });

        $items = $query->paginate($request->per_page);

        return response()->json($items);
    }
}

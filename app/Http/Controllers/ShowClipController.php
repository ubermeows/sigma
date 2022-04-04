<?php

namespace App\Http\Controllers;

use App\Models\Clip;
use App\Enums\ClipStates;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShowClipRequest;

class ShowClipController extends Controller
{
    public function __invoke(ShowClipRequest $request)
    {
        $query = Clip::query();

        $query->where('state', ClipStates::Active);

        $query->where('id', $request->hook)
            ->orWhere('tracking_id', $request->hook);

        $query->when($request->relations, function ($query) use ($request) {
            $query->with( ... $request->relations);
        });

        $item = $query->firstOrFail();

        return response()->json($item);
    }
}

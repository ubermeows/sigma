<?php

namespace App\Http\Controllers;

use App\Models\Clip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PopularClipRequest;

class PopularClipController extends Controller
{
    public function __invoke(PopularClipRequest $request)
    {
        $query = Clip::query();

        $query->orderBy(
            column: 'views', 
            direction: 'desc',
        );

        $query->whereBetween(
            'published_at', 
            $request->only('after_date', 'before_date'),
        );

        $items = $query->paginate($request->per_page);

        return response()->json($items);
    }
}

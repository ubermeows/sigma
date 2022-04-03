<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchGameRequest;

class SearchGameController extends Controller
{
    public function __invoke(SearchGameRequest $request)
    {
        $query = Game::query();

        $query->orderBy(
            column: $request->sort, 
            direction: $request->order,
        );

        $query->withCount('activeClips');

        $items = $query->paginate($request->per_page);

        return response()->json($items);
    }
}

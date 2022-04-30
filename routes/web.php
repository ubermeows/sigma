<?php

use App\Models\Clip;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

	$clips = Clip::select('title', 'state')
		->latest('published_at')
		->limit(10)
		->get();

    return view('welcome', ['clips' => $clips]);
});

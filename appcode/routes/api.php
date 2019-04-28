<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Authentication Routes...
Route::group(['middleware' => ['auth.basic']], function() {
	Route::post('/v1/team', 'v1\TeamController@saveTeam');
	Route::delete('/v1/team/{id}', 'v1\TeamController@deleteTeam')->where('id', '[0-9]+');
	Route::post('/v1/player', 'v1\PlayerController@savePlayer');
	Route::delete('/v1/player/{id}', 'v1\PlayerController@deletePlayer')->where('id', '[0-9]+');
});

Route::group(['prefix' => 'v1'], function() {
	Route::get('/team', 'v1\TeamController@getTeamContent');
	Route::get('/team/{search}', 'v1\TeamController@getSearchedTeam')->where('search', '[a-zA-Z]+');
	Route::get('/team/details/{id}', 'v1\TeamController@getTeamDetail')->where('id', '[0-9]+');

	Route::get('/player', 'v1\PlayerController@getPlayerContent');
	Route::get('/player/{search}', 'v1\PlayerController@getSearchedPlayer')->where('search', '[a-zA-Z]+');
	Route::get('/player/details/{id}', 'v1\PlayerController@getPlayerDetail')->where('id', '[0-9]+');

	Route::get('/search/{slug}', 'v1\HomeController@getSearchedInfo')->where('slug', '[a-zA-Z]+');
});

Route::fallback(function() {
	return response()->json([
		'message' => 'Page Not Found'], 404
	);
});
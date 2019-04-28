<?php

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

Auth::routes();

Route::get('/', function() {
	return view('home');
})->name('home');

Route::get('login', 'Auth\LoginController@showLoginForm');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Authentication Routes...
Route::group(['middleware' => ['auth']], function() {
	Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
	Route::get('/dashboard/content', 'DashboardController@getDashboardContent')->name('dashboard.content');
		
	Route::get('/team', 'v1\TeamController@index')->name('team');
	Route::get('/team/content', 'v1\TeamController@getTeamContent')->name('team.content');
	Route::post('/team', 'v1\TeamController@saveTeam')->name('team.save');
	Route::delete('/team/{id}', 'v1\TeamController@deleteTeam')->name('team.delete');
	Route::get('/team/{id}', 'v1\TeamController@editTeam')->name('team.edit');
	
	Route::get('/player', 'v1\PlayerController@index')->name('player');
	Route::get('/player/content', 'v1\PlayerController@getPlayerContent')->name('player.content');
	Route::post('/player', 'v1\PlayerController@savePlayer')->name('player.save');
	Route::delete('/player/{id}', 'v1\PlayerController@deletePlayer')->name('player.delete');
	Route::get('/player/{id}', 'v1\PlayerController@editPlayer')->name('player.edit');
});


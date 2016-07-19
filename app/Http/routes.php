<?php

use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/load/{file}', 'LoadController@songs');

Route::get('/download/{file}', function ($file) {
	$filepath = public_path(). "/download/" . $file;
	$extension = pathinfo($file)['extension'];
	switch ($extension) {
		case 'csv':
			$mime = 'text/csv';
			break;
	}
	$headers = ['Content-Type: $mime'];
	return Response::download($filepath, $file, $headers);
});

Route::get('/music/artists/{artist_id}/favoritedBy/{user_id}', 'ArtistsController@favoritedBy');
Route::get('/music/artists/{artist_id}/unfavoritedBy/{user_id}', 'ArtistsController@unfavoritedBy');
Route::resource('/music/artists', 'ArtistsController');

Route::get('/music/albums/{album_id}/favoritedBy/{user_id}', 'AlbumsController@favoritedBy');
Route::get('/music/albums/{album_id}/unfavoritedBy/{user_id}', 'AlbumsController@unfavoritedBy');
Route::resource('/music/albums', 'AlbumsController');

Route::get('/music/songs/{song_id}/favoritedBy/{user_id}', 'SongsController@favoritedBy');
Route::get('/music/songs/{song_id}/unfavoritedBy/{user_id}', 'SongsController@unfavoritedBy');
Route::resource('/music/songs', 'SongsController');

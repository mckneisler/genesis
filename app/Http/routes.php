<?php

use Carbon\Carbon;
use App\Models\Code;
use App\Models\OptionUserValue;
use App\Models\Admin\Permission;

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
})->middleware('maint');

Route::auth();

Route::get('/home', 'HomeController@index')
	->middleware('maint');

Route::get('/load/{file}', 'LoadController@songs')
	->middleware('maint');

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
})->middleware('maint');

Route::get('/music/artists/{artists}/favoritedBy/{users}', 'Music\ArtistsController@favoritedBy')
	->middleware('maint');
Route::get('/music/artists/{artists}/unfavoritedBy/{users}', 'Music\ArtistsController@unfavoritedBy')
	->middleware('maint');
Route::resource('/music/artists', 'Music\ArtistsController', ['except' => ['show', 'destroy']]);

Route::get('/music/albums/{albums}/favoritedBy/{users}', 'Music\AlbumsController@favoritedBy')
	->middleware('maint');
Route::get('/music/albums/{albums}/unfavoritedBy/{users}', 'Music\AlbumsController@unfavoritedBy')
	->middleware('maint');
Route::resource('/music/albums', 'Music\AlbumsController', ['except' => ['show', 'destroy']]);

Route::get('/music/songs/{songs}/favoritedBy/{users}', 'Music\SongsController@favoritedBy')
	->middleware('maint');
Route::get('/music/songs/{songs}/unfavoritedBy/{users}', 'Music\SongsController@unfavoritedBy')
	->middleware('maint');
Route::resource('/music/songs', 'Music\SongsController', ['except' => ['show', 'destroy']]);

Route::bind('codes', function ($value) {
	$type_path = Route::current()->getParameter('types');

	list($parent, $type) = code()->getParentFromPath($type_path);
	$code =  Code::select(
			'id',
			'code',
			'values_code_id',
			'codes.created_at',
			'codes.updated_at',
			'codes.deleted_at',
			'codes.created_by',
			'codes.updated_by',
			'codes.deleted_by'
		)
		->where('parent_code_id', $type->id)
		->where('code', $value)
		->locale(['name', 'description'])
		->withTrashed()
		->first();
	return $code;
});
Route::resource('admin.codes', 'Admin\CodesController', [
	'parameters' => [
	    'admin' => 'types'
	],
	'except' => [
	    'show',
		'destroy'
	]
]);

Route::get('/admin/maint/{mode}', function ($mode) {
    Artisan::call($mode);
	flash()->embed(
		trans('phrase.maintMode'),
		trans('phrase.maintStatus', ['mode' => $mode]),
		'warning'
	);
    return redirect('/');
})->middleware('auth')->middleware('permission:maint-edit');

Route::resource('/admin/security/permissions', 'Admin\PermissionsController', ['except' => ['show', 'destroy']]);

Route::resource('/admin/security/permissions.records', 'Admin\PermissionRecordsController', [
	'parameters' => [
	    'admin' => null,
	    'security' => null,
	    'permissions' => 'permissions'
	],
	'except' => [
	    'show',
		'destroy'
	]
]);

Route::resource('/admin/security/users', 'UsersController', [
	'except' => [
		'show',
		'destroy'
	]
]);

Route::resource('/admin/options', 'OptionsController', [
	'parameters' => [
	    'options' => 'users'
	],
	'only' => [
		'edit',
		'update'
	]
]);

Route::resource('/users/options', 'OptionsController', [
	'parameters' => [
	    'options' => 'users'
	],
	'only' => [
		'edit',
		'update'
	]
]);

Route::resource('/users/profile', 'UsersController', [
	'parameters' => [
	    'profile' => 'users'
	],
	'only' => [
		'edit',
		'update'
	]
]);

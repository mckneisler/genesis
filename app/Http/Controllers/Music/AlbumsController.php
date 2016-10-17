<?php

namespace App\Http\Controllers\Music;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Music\AlbumRequest;
use App\Models\Music\Artist;
use App\Models\Music\Album;
use App\Models\Music\AlbumFilters;

class AlbumsController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth', ['only' => 'create']);

	}

    public function index(AlbumFilters $filters)
	{
		/*
		 * Default sort
		 */
		if ( ! request()->has('sort')) {
			request()->request->add(['sort' => 'artist']);
			request()->request->add(['order' => 'asc']);
		}
		session()->put('url.back', request()->fullUrl());

		$type = code('objects.albums');
		$albums = Album::select(
				'albums.id as album_id',
				'albums.name as album_name',
				'artists.id as artist_id',
				'artists.name as artist_name'
			)
			->join('artists', 'albums.artist_id', '=', 'artists.id')
			->filter($filters)
			->withFavorites()
			->get();
		$artists = Artist::orderBy('name')
			->lists('name', 'id')
			->toArray();
		$defaults = [];
		if (request()->has('artist_id')) {
			$defaults['artist_id'] = request()->artist_id;
		}
		$favorites = [
			1 => trans('phrase.yes'),
			0 => trans('phrase.no')
		];
		return view('music.albums.index', compact(
			'type',
			'albums',
			'artists',
			'defaults',
			'favorites'
		));
	}

    public function create()
	{
		$artists = Artist::orderBy('name')
			->lists('name', 'id')
			->toArray();
		return view('music.albums.create', compact('artists'));
	}

	public function store(AlbumRequest $request)
	{
		Album::create($request->all());
		flash()->success(
			trans('phrase.successCreate'),
			trans('phrase.objectCreated', [
				'object' => choose(code('objects.albums')->name, 1),
				'name' => $request->name
			])
		);
		return redirect(session()->get('url.back', '/music/albums'));
	}

	public function edit(Album $album)
	{
		$artists = Artist::orderBy('name')
			->lists('name', 'id')
			->toArray();
		return view('music.albums.edit', compact('album', 'artists'));
	}

	public function update(Album $album, AlbumRequest $request)
	{
		$album->update($request->all());
		flash()->success(
			trans('phrase.successUpdate'),
			trans('phrase.objectUpdated', [
				'object' => choose(code('objects.albums')->name, 1),
				'name' => $request->name
			])
		);
		return redirect(session()->get('url.back', '/music/albums'));
	}

	public function favoritedBy($album, $user_id)
	{
		if (!$album->users->contains($user_id)) {
			$album->users()->attach($user_id);
			return trans('action.added');
		}
		return '';
	}

	public function unfavoritedBy($album, $user_id)
	{
		$album->users()->detach($user_id);
		return trans('action.deleted');
	}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\AlbumRequest;
use App\Http\Requests;
use DB;
use App\Artist;
use App\Album;
use App\AlbumFilters;
use Auth;

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
		if (!request()->has('sort')) {
			request()->request->add(['sort' => 'artist']);
			request()->request->add(['order' => 'asc']);
		}

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
		return view('albums.index', compact(
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
		return view('albums.create', compact('artists'));
	}

	public function store(AlbumRequest $request)
	{
		Album::create($request->all());
		flash()->success(
			trans('phrase.successCreate'),
			trans('phrase.objectCreated', [
				'object' => trans_choice('object.album', 1),
				'name' => $request->name
			])
		);
		return redirect('/music/albums');
	}

	public function edit(Album $album)
	{
		$artists = Artist::orderBy('name')
			->lists('name', 'id')
			->toArray();
		return view('albums.edit', compact('album', 'artists'));
	}

	public function update(Album $album, AlbumRequest $request)
	{
		$album->update($request->all());
		flash()->success(
			trans('phrase.successUpdate'),
			trans('phrase.objectUpdated', [
				'object' => trans_choice('object.album', 1),
				'name' => $request->name
			])
		);
		return redirect('/music/albums');
	}

	public function favoritedBy($album_id, $user_id)
	{
		$album = Album::findOrFail($album_id);
		if (!$album->users->contains($user_id)) {
			$album->users()->attach($user_id);
			return trans('action.added');
		}
		return '';
	}

	public function unfavoritedBy($album_id, $user_id)
	{
		Album::findOrFail($album_id)->users()->detach($user_id);
		return trans('action.deleted');
	}
}

<?php

namespace App\Http\Controllers\Music;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\Music\SongRequest;
use App\Http\Requests;
use App\Models\Music\Artist;
use App\Models\Music\Album;
use App\Models\Music\Song;
use App\Models\Music\SongFilters;
use Auth;

class SongsController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth', ['only' => 'create']);

	}

    public function index(SongFilters $filters)
	{
		/*
		 * Default sort
		 */
		if ( ! request()->has('sort')) {
			request()->request->add(['sort' => 'artist']);
			request()->request->add(['order' => 'asc']);
		}
		session()->put('url.back', request()->fullUrl());

		$type = code('objects.songs');
		$songs = Song::select(
				'songs.id',
				'artists.name as artist_name',
				'albums.name as album_name',
				'songs.name as song_name'
			)
			->join('albums', 'songs.album_id', '=', 'albums.id')
			->join('artists', 'songs.artist_id', '=', 'artists.id')
			->filter($filters)
			->withFavorites()
			->get();
		$artists = Artist::orderBy('name')
			->lists('name', 'id')
			->toArray();
		$albums = Album::orderBy('name')
			->lists('name', 'id')
			->toArray();
		$defaults = [];
		if (request()->has('artist_id')) {
			$defaults['artist_id'] = request()->artist_id;
		}
		if (request()->has('album_id')) {
			$defaults['album_id'] = request()->album_id;
		}
		$favorites = [
			1 => trans('phrase.yes'),
			0 => trans('phrase.no')
		];
		return view('music.songs.index', compact(
			'type',
			'songs',
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
		$albums = Album::orderBy('name')
			->lists('name', 'id')
			->toArray();
		return view('music.songs.create', compact('artists', 'albums'));
	}

	public function store(SongRequest $request)
	{
		Song::create($request->all());
		flash()->success(
			trans('phrase.successCreate'),
			trans('phrase.objectCreated', [
				'object' => trans_choice('object.song', 1),
				'name' => $request->name
			])
		);
		return redirect(session()->get('url.back', '/music/songs'));
	}

	public function edit(Song $song)
	{
		$artists = Artist::orderBy('name')
			->lists('name', 'id')
			->toArray();
		$albums = Album::orderBy('name')
			->lists('name', 'id')
			->toArray();
		return view('music.songs.edit', compact('song', 'artists', 'albums'));
	}

	public function update(Song $song, SongRequest $request)
	{
		$song->fill($request->all());
		if ($song->isDirty()) {
			$song->update();
			flash()->success(
				trans('phrase.successUpdate'),
				trans('phrase.objectUpdated', [
					'object' => trans_choice('object.song', 1),
					'name' => $request->name
				])
			);
		} else {
			flash()->info(
				trans('phrase.nothingSaved'),
				trans('phrase.noChanges')
			);
		}

		return redirect(session()->get('url.back', '/music/songs'));
	}

	public function favoritedBy($song, $user_id)
	{
		if (!$song->users->contains($user_id)) {
			$song->users()->attach($user_id);
			return trans('action.added');
		}
		return '';
	}

	public function unfavoritedBy($song, $user_id)
	{
		$song->users()->detach($user_id);
		return trans('action.deleted');
	}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\SongRequest;
use App\Http\Requests;

use App\Artist;
use App\Album;
use App\Song;
use App\SongFilters;
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
		if (!request()->has('sort')) {
			request()->request->add(['sort' => 'artist']);
			request()->request->add(['order' => 'asc']);
		}

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
		return view('songs.index', compact(
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
		return view('songs.create', compact('artists', 'albums'));
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
		return redirect('/music/songs');
	}

	public function edit(Song $song)
	{
		$artists = Artist::orderBy('name')
			->lists('name', 'id')
			->toArray();
		$albums = Album::orderBy('name')
			->lists('name', 'id')
			->toArray();
		return view('songs.edit', compact('song', 'artists', 'albums'));
	}

	public function update(Song $song, SongRequest $request)
	{
		$song->update($request->all());
		flash()->success(
			trans('phrase.successUpdate'),
			trans('phrase.objectUpdated', [
				'object' => trans_choice('object.song', 1),
				'name' => $request->name
			])
		);
		return redirect('/music/songs');
	}

	public function favoritedBy($song_id, $user_id)
	{
		$song = Song::findOrFail($song_id);
		if (!$song->users->contains($user_id)) {
			$song->users()->attach($user_id);
			return trans('action.added');
		}
		return '';
	}

	public function unfavoritedBy($song_id, $user_id)
	{
		Song::findOrFail($song_id)->users()->detach($user_id);
		return trans('action.deleted');
	}
}

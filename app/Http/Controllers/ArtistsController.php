<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ArtistRequest;
use App\Artist;
use App\ArtistFilters;
use Auth;


class ArtistsController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth', ['only' => 'create']);

	}

    public function index(ArtistFilters $filters)
	{
		/*
		 * Default sort
		 */
		if (!request()->has('sort')) {
			request()->request->add(['sort' => 'artist']);
			request()->request->add(['order' => 'asc']);
		}
		$artists = Artist::select(
				'id',
				'artists.name as artist_name'
			)
			->filter($filters)
			->withFavorites()
			->get();
		$favorites = [
			1 => trans('phrase.yes'),
			0 => trans('phrase.no')
		];
		return view('artists.index', compact(
			'artists',
			'favorites'
		));
	}

    public function create()
	{
		return view('artists.create');
	}

	public function store(ArtistRequest $request)
	{
		Artist::create($request->all());
		flash()->success(
			trans('phrase.successCreate'),
			trans('phrase.objectCreated', [
				'object' => trans_choice('object.artist', 1),
				'name' => $request->name
			])
		);
		return redirect('/music/artists');
	}

	public function edit(Artist $artist)
	{
		return view('artists.edit', compact('artist'));
	}

	public function update(Artist $artist, ArtistRequest $request)
	{
		$artist->update($request->all());
		flash()->success(
			trans('phrase.successUpdate'),
			trans('phrase.objectUpdated', [
				'object' => trans_choice('object.artist', 1),
				'name' => $request->name
			])
		);
		return redirect('/music/artists');
	}

	public function favoritedBy($artist_id, $user_id)
	{
		$artist = Artist::findOrFail($artist_id);
		if (!$artist->users->contains($user_id)) {
			$artist->users()->attach($user_id);
			return trans('action.added');
		}
		return '';
	}

	public function unfavoritedBy($artist_id, $user_id)
	{
		Artist::findOrFail($artist_id)->users()->detach($user_id);
		return trans('action.deleted');
	}
}

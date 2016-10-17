<?php

namespace App\Http\Controllers\Music;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\Music\ArtistRequest;
use App\Models\Music\Artist;
use App\Models\Music\ArtistFilters;
use App\Models\Code;
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
		if ( ! request()->has('sort')) {
			request()->request->add(['sort' => 'artist']);
			request()->request->add(['order' => 'asc']);
		}
		session()->put('url.back', request()->fullUrl());

		$type = code('objects.artists');
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
		return view('music.artists.index', compact(
			'type',
			'artists',
			'favorites'
		));
	}

    public function create()
	{
		return view('music.artists.create');
	}

	public function store(ArtistRequest $request)
	{
		Artist::create($request->all());
		flash()->success(
			trans('phrase.successCreate'),
			trans('phrase.objectCreated', [
				'object' => choose(code('objects.artists')->name, 1),
				'name' => $request->name
			])
		);
		return redirect(session()->get('url.back', '/music/artists'));
	}

	public function edit(Artist $artist)
	{
		return view('music.artists.edit', compact('artist'));
	}

	public function update(Artist $artist, ArtistRequest $request)
	{
		$artist->update($request->all());
		flash()->success(
			trans('phrase.successUpdate'),
			trans('phrase.objectUpdated', [
				'object' => choose(code('objects.artists')->name, 1),
				'name' => $request->name
			])
		);
		return redirect(session()->get('url.back', '/music/artists'));
	}

	public function favoritedBy($artist, $user_id)
	{
		if (!$artist->users->contains($user_id)) {
			$artist->users()->attach($user_id);
			return trans('action.added');
		}
		return '';
	}

	public function unfavoritedBy($artist, $user_id)
	{
		$artist->users()->detach($user_id);
		return trans('action.deleted');
	}
}

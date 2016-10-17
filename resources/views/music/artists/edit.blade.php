@extends('layouts.form', [
	'title' => choose(code('objects.artists')->name, 1),
	'url' => url('/music/artists/' . $artist->id),
	'method' => 'PATCH',
	'model' => $artist
])

@include('music.artists.form', [
	'model' => $artist
])

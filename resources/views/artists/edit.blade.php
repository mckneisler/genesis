@extends('layouts.form', [
	'title' => trans('phrase.editObject', ['object' => trans_choice('object.artist', 1)]),
	'url' => url('/music/artists/' . $artist->id),
	'method' => 'PATCH',
	'model' => $artist
])

@include('artists.form', [
	'submitButtonText' => trans('phrase.updateObject', ['object' => trans_choice('object.artist', 1)]),
	'model' => $artist
])

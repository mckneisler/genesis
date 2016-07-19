@extends('layouts.form', [
	'title' => trans('phrase.editObject', ['object' => trans_choice('object.song', 1)]),
	'url' => url('/music/songs/' . $song->id),
	'method' => 'PATCH',
	'model' => $song
])

@include('songs.form', [
	'submitButtonText' => trans('phrase.updateObject', ['object' => trans_choice('object.song', 1)]),
	'model' => $song
])

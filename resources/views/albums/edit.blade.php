@extends('layouts.form', [
	'title' => trans('phrase.editObject', ['object' => trans_choice('object.album', 1)]),
	'url' => url('/music/albums/' . $album->id),
	'method' => 'PATCH',
	'model' => $album
])

@include('albums.form', [
	'submitButtonText' => trans('phrase.updateObject', ['object' => trans_choice('object.album', 1)]),
	'model' => $album
])

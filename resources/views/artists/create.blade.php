@extends('layouts.form', [
	'title' => trans('phrase.newObject', ['object' => trans_choice('object.artist', 1)]),
	'url' => url('/music/artists')
])

@include('artists.form', [
	'submitButtonText' => trans('phrase.addObject', ['object' => trans_choice('object.artist', 1)])
])

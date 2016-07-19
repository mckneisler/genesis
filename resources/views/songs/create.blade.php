@extends('layouts.form', [
	'title' => trans('phrase.newObject', ['object' => trans_choice('object.song', 1)]),
	'url' => url('/music/songs')
])

@include('songs.form', [
	'submitButtonText' => trans('phrase.addObject', ['object' => trans_choice('object.song', 1)])
])

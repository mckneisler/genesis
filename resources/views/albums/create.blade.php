@extends('layouts.form', [
	'title' => trans('phrase.newObject', ['object' => trans_choice('object.album', 1)]),
	'url' => url('/music/albums')
])

@include('albums.form', [
	'submitButtonText' => trans('phrase.addObject', ['object' => trans_choice('object.album', 1)])
])

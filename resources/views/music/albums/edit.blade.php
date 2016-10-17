@extends('layouts.form', [
	'title' => choose(code('objects.albums')->name, 1),
	'url' => url('/music/albums/' . $album->id),
	'method' => 'PATCH',
	'model' => $album
])

@include('music.albums.form', [
	'model' => $album
])

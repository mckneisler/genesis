@extends('layouts.form', [
	'title' => choose(code('objects.songs')->name, 1),
	'url' => url('/music/songs/' . $song->id),
	'method' => 'PATCH',
	'model' => $song
])

@include('music.songs.form', [
	'model' => $song
])

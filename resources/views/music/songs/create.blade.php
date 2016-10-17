@extends('layouts.form', [
	'title' => choose(code('objects.songs')->name, 1),
	'url' => url('/music/songs')
])

@include('music.songs.form')

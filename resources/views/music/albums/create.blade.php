@extends('layouts.form', [
	'title' => choose(code('objects.albums')->name, 1),
	'url' => url('/music/albums')
])

@include('music.albums.form')

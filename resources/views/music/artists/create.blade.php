@extends('layouts.form', [
	'title' => choose(code('objects.artists')->name, 1),
	'url' => url('/music/artists')
])

@include('music.artists.form')

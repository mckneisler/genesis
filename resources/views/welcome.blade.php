@extends('layouts.panel', ['title' => trans('phrase.welcomeTo', ['appTitle' => config('custom.appName') . ' ' . trans('phrase.title')])])

@section('panelContent')
	<p>{{ trans('phrase.siteDesc', ['appName' => config('custom.appName')]) }}</p>

	@if (Auth::guest())
		<p>{{ trans('phrase.pleaseLogin') }}</p>
	@endif
@endsection

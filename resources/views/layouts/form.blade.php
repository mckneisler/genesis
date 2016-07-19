@extends('layouts.panel', ['title' => $title])

@section('panelContent')
	@if (isset($model))
		{!! Form::model($model, [
			'class' => 'form-horizontal',
			'role' => 'form',
			'method' => isset($method) ? $method : 'POST',
			'url' => $url
		]) !!}
	@else
		{!! Form::open([
			'class' => 'form-horizontal',
			'role' => 'form',
			'method' => isset($method) ? $method : 'POST',
			'url' => $url
		]) !!}
	@endif
{{--
	<form class="form-horizontal" role="form" method="{{ $method or 'POST' }}" action="{{ $action }}">
		{{ csrf_field() }}
--}}

		@yield('formContent')

{{--
	</form>
--}}
	{!! Form::close() !!}
@endsection

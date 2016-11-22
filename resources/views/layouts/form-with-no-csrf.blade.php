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
		@if (isset($no_csrf) && $no_csrf)
			<form
				method="{{ $method or 'POST' }}"
				action="{{ $url }}"
				accept-charset="UTF-8"
				class="form-horizontal"
				role="form"
			>
		@else
			{!! Form::open([
				'class' => 'form-horizontal',
				'role' => 'form',
				'method' => isset($method) ? $method : 'POST',
				'url' => $url
			]) !!}
		@endif
	@endif

	@yield('formContent')

	{!! Form::close() !!}
@endsection

@section('footerContent')
	@if (is_null(oldModelValue('created_at', defaultValue($model))))
		&nbsp;
	@else
		<div class="row footer-padding">
			@if (is_null(oldModelValue('deleted_at', defaultValue($model))))
				<!-- Left -->
				<div class="w3-half w3-hide-small">
					{{ trans('phrase.created') }}
					{{
						datePhrase(
							oldModelValue('created_by', defaultValue($model)),
							oldModelValue('created_at', defaultValue($model))
						)
					}}
				</div>
				<!-- Center -->
				<div class="w3-center w3-hide-medium w3-hide-large">
					{{ trans('phrase.updated') }}
					{{
						datePhrase(
							oldModelValue('updated_by', defaultValue($model)),
							oldModelValue('updated_at', defaultValue($model))
						)
					}}
				</div>
				<!-- Right -->
				<div class="w3-half text-right w3-hide-small">
					{{ trans('phrase.updated') }}
					{{
						datePhrase(
							oldModelValue('updated_by', defaultValue($model)),
							oldModelValue('updated_at', defaultValue($model))
						)
					}}
				</div>
			@else
				<!-- Left -->
				<div class="w3-third w3-hide-small">
					{{ trans('phrase.created') }}
					{{
						datePhrase(
							oldModelValue('created_by', defaultValue($model)),
							oldModelValue('created_at', defaultValue($model))
						)
					}}
				</div>
				<!-- Center -->
				<div class="w3-third w3-center">
					{{ trans('phrase.updated') }}
					{{
						datePhrase(
							oldModelValue('updated_by', defaultValue($model)),
							oldModelValue('updated_at', defaultValue($model))
						)
					}}
				</div>
				<!-- Right -->
				<div class="w3-third text-right w3-hide-small">
					{{ trans('phrase.deleted') }}
					{{
						datePhrase(
							oldModelValue('deleted_by', defaultValue($model)),
							oldModelValue('deleted_at', defaultValue($model))
						)
					}}
				</div>
			@endif
		</div>
	@endif
@endsection

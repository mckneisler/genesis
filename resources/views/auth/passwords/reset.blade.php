@extends('layouts.form', ['title' => trans('phrase.resetPassword'), 'action' => url('/password/reset')])

@section('formContent')
	<input type="hidden" id="setFocusId" value="{{ count($errors) ? $errors->keys()[0] : 'email' }}" />

	<input type="hidden" name="token" value="{{ $token }}">

	@include('layouts.input', ['name' => 'email'])

	@include('layouts.input', ['name' => 'password', 'type' => 'password'])

	@include('layouts.input', [
		'name' => 'password_confirmation',
		'type' => 'password',
		'label' => trans('phrase.confirmObject', ['object' => trans('object.password')])]
	)

	@include('layouts.input', [
		'name' => 'reset',
		'type' => 'button',
		'label' => trans('phrase.resetPassword'),
		'icon' => 'fa-refresh']
	)
@endsection

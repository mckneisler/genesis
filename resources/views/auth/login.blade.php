@extends('layouts.form', ['title' => trans('action.login'), 'url' => url('/login')])

@section('formContent')
	<input type="hidden" id="setFocusId" value="{{ count($errors) ? $errors->keys()[0] : 'email' }}" />

	@include('layouts.input', ['name' => 'email'])

	@include('layouts.input', ['name' => 'password', 'type' => 'password'])

	@include('layouts.input', [
		'name' => 'remember',
		'type' => 'checkbox',
		'label' => trans('phrase.rememberMe')]
	)

	@include('layouts.input', [
		'name' => 'login',
		'type' => 'button',
		'icon' => 'fa-sign-in',
		'linkUrl' => '/password/reset',
		'linkPhrase' => trans('phrase.forgotYourPassword', ['password' => trans('object.password')])]
	)
@endsection

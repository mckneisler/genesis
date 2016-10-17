@extends('layouts.form', ['title' => trans('action.register'), 'url' => url('/register')])

@section('formContent')
	<input type="hidden" id="set_focus_id" value="{{ count($errors) ? $errors->keys()[0] : 'name' }}">

	@include('layouts.input', ['name' => 'name'])

	@include('layouts.input', ['name' => 'email'])

	@include('layouts.input', ['name' => 'password', 'type' => 'password'])

	@include('layouts.input', [
		'name' => 'password_confirmation',
		'type' => 'password',
		'label' => trans('phrase.confirmObject', ['object' => trans('object.password')])]
	)

	@include('layouts.button.single', [
		'name' => 'register',
		'icon' => 'fa-user']
	)
@endsection

@extends('layouts.form', ['title' => trans('phrase.resetPassword'), 'url' => url('/password/reset')])

@section('formContent')
	<input type="hidden" id="set_focus_id" value="{{ count($errors) ? $errors->keys()[0] : 'email' }}">

	<input type="hidden" name="token" value="{{ $token }}">

	@include('layouts.input', ['name' => 'email'])

	@include('layouts.input', ['name' => 'password', 'type' => 'password'])

	@include('layouts.input', [
		'name' => 'password_confirmation',
		'type' => 'password',
		'label' => trans('phrase.confirmObject', ['object' => trans('object.password')])]
	)

	@include('layouts.button.single', [
		'name' => 'reset',
		'label' => trans('phrase.resetPassword'),
		'icon' => 'fa-refresh']
	)
@endsection

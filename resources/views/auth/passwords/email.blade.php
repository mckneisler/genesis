@extends('layouts.form', ['title' => trans('phrase.resetPassword'), 'url' => url('/password/email')])

@section('formContent')
	<input type="hidden" id="set_focus_id" value="{{ count($errors) ? $errors->keys()[0] : 'email' }}">

	@include('layouts.input', ['name' => 'email'])

	@include('layouts.button.single', [
		'name' => 'requestReset',
		'label' => trans('phrase.sendReset'),
		'icon' => 'fa-envelope']
	)
@endsection

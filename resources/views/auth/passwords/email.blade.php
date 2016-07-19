@extends('layouts.form', ['title' => trans('phrase.resetPassword'), 'action' => url('/password/email')])

@section('formContent')
	<input type="hidden" id="setFocusId" value="{{ count($errors) ? $errors->keys()[0] : 'email' }}" />

	@include('layouts.input', ['name' => 'email'])

	@include('layouts.input', [
		'name' => 'requestReset',
		'type' => 'button',
		'label' => trans('phrase.sendReset'),
		'icon' => 'fa-envelope']
	)
@endsection

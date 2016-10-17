@extends('layouts.form', [
	'title' => choose(code('types.options')->name, 2),
	'url' => url('/' . request()->segments()[0] . '/options/' . $user->id),
	'method' => 'PATCH',
	'model' => $model
])

@if (in_array('admin', Request::segments()))
	@section('prePanelContent')
		<form id="user_form" name="user_form" class="form-horizontal" action="/admin/options/{select_id}/edit">
			@include('layouts.input', [
				'name' => 'user_id',
				'type' => 'select',
				'label' => choose(code('objects.users')->name, 1),
				'values' => $users,
				'nullText' => trans('phrase.selectOne'),
				'value' => 'id',
				'text' => 'name',
				'onchange' => 'formActionUpdateAndSubmit(this, this.form)'
			])
		</form>
	@endsection
@endif

@section('formContent')
	<input type="hidden" id="set_focus_id" value="{{ count($errors) ? $errors->keys()[0] : 'user_id' }}">

	@foreach ($options as $option)
		@include('layouts.options', [
			'option' => $option
		])
	@endforeach

	@include('layouts.button.bar.saveCancel', [
		'default' => '/',
		'no_back' => true
	])
@endsection

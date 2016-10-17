@section('formContent')
	<input type="hidden" id="set_focus_id" value="{{ count($errors) ? $errors->keys()[0] : 'name' }}">
	<input type="hidden" name="id" value="{{ oldModelValue('id', defaultValue($model)) }}">

	@include('layouts.input', [
		'name' => 'name',
		'type' => 'text'
	])

	@include('layouts.input', [
		'name' => 'email',
		'type' => 'text'
	])

	@include('layouts.input', [
		'name' => 'password',
		'type' => 'password'
	])

	@include('layouts.input', [
		'name' => 'password_confirmation',
		'type' => 'password',
		'label' => trans('phrase.confirmObject', ['object' => trans('object.password')])]
	)

	@if (in_array('admin', Request::segments()))
		@include('layouts.input', [
			'name' => 'role_list',
			'type' => 'multiselect',
			'label' => choose(code('objects.roles')->name, 2),
			'values' => $roles,
			'value' => 'id',
			'text' => 'name'
		])

		@if ($mode == 'edit')
			@include('layouts.input', [
				'type' => 'checkbox',
				'name' => 'disabled',
				'label' => code('statuses.disabled')->name,
				'condition' => '! is_null',
				'conditionField' => 'deleted_at'
			])
		@endif
	@endif

	@if (in_array('admin', Request::segments()))
		@include('layouts.button.bar.saveCancel', ['default' => '/admin/' . code()->getPathFromId($type->id) . '/codes'])
	@else
		@include('layouts.button.bar.saveCancel', ['default' => '/', 'no_back' => true])
	@endif
@endsection

@section('scripts')
	<script>
		$('#role_list').select2({placeholder: '{{ trans('phrase.chooseRoles') }}...'});
	</script>
@endsection

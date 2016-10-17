@section('formContent')
	<input type="hidden" id="set_focus_id" value="{{ count($errors) ? $errors->keys()[0] : 'record_id' }}">
	<input type="hidden" name="id" value="{{ oldModelValue('id', defaultValue($model)) }}">
	<input type="hidden" name="permission_id" value="{{ oldModelValue('permission_id', defaultValue($model), $permission->id) }}">
	<input type="hidden" id="record_name" name="record_name" value="{{ oldModelValue('record_name', defaultValue($model)) }}">

	@include('layouts.input', [
		'name' => 'record_id',
		'type' => 'select',
		'label' => choose(code('objects.records')->name, 1),
		'values' => $records,
		'nullText' => trans('phrase.selectOne'),
		'value' => 'id',
		'text' => 'name',
		'onchange' => 'setSelectField(this, \'record_name\')',
		'onload' => 'setSelectField($(\'#record_id\'), \'record_name\');',
		'disabled' => ($mode == 'create' && Gate::denies('records-add')) || ($mode == 'edit' && Gate::denies('records-edit'))
	])

	@include('layouts.input', [
		'name' => 'role_list',
		'type' => 'multiselect',
		'label' => choose(code('objects.roles')->name, 2),
		'values' => $roles,
		'value' => 'id',
		'text' => 'name'
	])

	@include('layouts.button.bar.saveCancel', ['default' => '/music/songs'])
@endsection

@section('scripts')
	<script>
		$('#role_list').select2({placeholder: '{{ trans('phrase.chooseRoles') }}...'});
	</script>
@endsection

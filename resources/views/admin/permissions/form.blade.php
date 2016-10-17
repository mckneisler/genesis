@section('formContent')
	<input type="hidden" id="set_focus_id" value="{{ count($errors) ? $errors->keys()[0] : 'object_id' }}">
	<input type="hidden" name="id" value="{{ oldModelValue('id', defaultValue($model)) }}">

	@include('layouts.input', [
		'name' => 'object_id',
		'type' => 'select',
		'label' => choose(code('objects.objects')->name, 1),
		'values' => $objects,
		'nullText' => trans('phrase.selectOne'),
		'value' => 'id',
		'text' => 'name',
		'disabled' => ($mode == 'create' && Gate::denies('permissions-add')) || ($mode == 'edit' && Gate::denies('permissions-edit'))
	])

	@include('layouts.input', [
		'name' => 'action_id',
		'type' => 'select',
		'label' => choose(code('objects.actions')->name, 1),
		'values' => $actions,
		'nullText' => trans('phrase.selectOne'),
		'value' => 'id',
		'text' => 'name',
		'disabled' => ($mode == 'create' && Gate::denies('permissions-add')) || ($mode == 'edit' && Gate::denies('permissions-edit'))
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

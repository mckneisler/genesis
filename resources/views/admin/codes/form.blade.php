@section('formContent')
	<input type="hidden" id="set_focus_id" value="{{ count($errors) ? $errors->keys()[0] : 'code' }}">
	<input type="hidden" name="id" value="{{ oldModelValue('id', defaultValue($model)) }}">
	<input type="hidden" name="parent_code_id" value="{{ $type->id }}" />

	@include('layouts.input', [
		'type' => 'text',
		'name' => 'code',
		'label' => choose(code('objects.codes')->name, 1)
	])

	@if ($mode == 'edit' && explode(':', $type_path)[0] == 'options' && ! $model->children()->count())
		@include('layouts.input', [
			'name' => 'values_code_id',
			'type' => 'select',
			'label' => choose(code('objects.values')->name, 2),
			'values' => $values,
			'nullText' => trans('phrase.selectOne'),
			'value' => 'id',
			'text' => 'name'
		])
	@endif

	@if ($mode == 'edit')
		@include('layouts.input', [
			'type' => 'checkbox',
			'name' => 'disabled',
			'label' => code('statuses.disabled')->name,
			'condition' => '! is_null',
			'conditionField' => 'deleted_at'
		])
	@endif

	<fieldset class="{{ config('class.fieldset') }}">
		<legend class='w3-text-theme'>{{ code('locales.' . App::getLocale())->name }}</legend>
		@include('layouts.input', [
			'type' => 'text',
			'name' => 'name'
		])

		@include('layouts.input', [
			'type' => 'textarea',
			'name' => 'description'
		])
	</fieldset>

	@include('layouts.button.bar.saveCancel', ['default' => '/admin/' . code()->getPathFromId($type->id) . '/codes'])
@endsection

@if ($option->childrenWithLocale()->count())
	@include('layouts.options.fieldset', [
		'name' => $option->name,
		'options' => $option->childrenWithLocale
	])
@else
	@include('layouts.input', [
		'name' => codePath($option->id) . '_value_id',
		'type' => 'select',
		'label' => $option->name,
		'values' => ${code($option->values_code_id)->code},
		'nullText' => trans('phrase.selectOne'),
		'value' => 'id',
		'text' => 'name'
	])
@endif

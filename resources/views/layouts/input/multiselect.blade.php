<select
	class="js-example-basic-multiple js-states form-control"
	id="{{ $select['name'] }}"
	name="{{ $select['name'] }}[]"
	multiple
>
	@foreach($select['values'] as $id => $name)
		<option
			value="{{ $id }}"
			@if (in_array($id, oldModelValue($select['name'], defaultValue($model), [])))
				selected
			@endif
		>
			{!! choose($name, 1) !!}
		</option>
	@endforeach
</select>

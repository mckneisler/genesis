<select
	class="form-control"
	name="{{ $select['name'] }}"
	@if(array_has($select, 'onchange'))
		onchange="{{ $select['onchange'] }}"
	@endif
>
	@if (array_has($select, 'nullText'))
		<option value="">
			&lt;{{ $select['nullText'] }}&gt;
		</option>
	@endif
	@foreach($select['values'] as $id => $name)
		<option
			value="{{ $id }}"
			@if (strval($id) === request()->{$select['name']}
				|| strval($id) === old($select['name'])
				|| (isset($model) && strval($id) === strval($model->{$select['name']}))
			)
				selected
			@endif
		>
			{!! $name !!}
		</option>
	@endforeach
</select>

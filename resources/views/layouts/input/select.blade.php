<select
	class="selectpicker form-control"
	data-container=".main"
	id="{{ $select['name'] }}"
	name="{{ $select['name'] }}"
	@if(array_has($select, 'onchange'))
		onchange="{{ $select['onchange'] }}"
	@endif
	@if(array_has($select, 'disabled') && $select['disabled'])
		disabled
	@endif
>
	@if (array_has($select, 'nullText'))
		<option value="">
			&lt;{{ $select['nullText'] }}&gt;
		</option>
	@endif
	@foreach($select['values'] as $id => $name)
		<option
			@if (is_array($name))
				data-subtext="{!! $name['description'] !!}"
				@if (isset($code) && ($code == 'font' || $code == 'theme'))
					class="{!! $name['code'] !!}"
				@endif
			@endif
			value="{{ $id }}"
			@if (strval($id) === request()->{$select['name']}
				|| strval($id) === strval(oldModelValue($select['name'], defaultValue($model), null))
			)
				selected
			@endif
		>
			@if (is_array($name))
				{!! choose($name['name'], 1) !!}
			@else
				{!! choose($name, 1) !!}
			@endif
		</option>
	@endforeach
</select>

@if(array_has($select, 'onload'))
	@section('scriptsSelect')
		<script type="text/javascript">
			$(function() {
				{!! $select['onload'] !!}
			});
		</script>
	@endsection
@endif
<!--<button type="button" class="btn btn-default" onclick="getInfo()">X</button>-->

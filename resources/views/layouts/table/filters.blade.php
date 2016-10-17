<tr>
	@foreach ($table['columns'] as $column)
		@if ( ! array_has($column, 'condition') || $column['condition'])
			<td>
				@if (array_has($column, 'filter'))
					@include('layouts.input.select', ['select' => $column['filter']])
				@else
					&nbsp;
				@endif
			</td>
		@endif
	@endforeach
</tr>

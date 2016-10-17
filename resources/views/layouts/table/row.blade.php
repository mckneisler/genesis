<tr class="w3-hover-theme-l4">
	@foreach ($table['columns'] as $column)
		@if ( ! array_has($column, 'condition') || $column['condition'])
			@include('layouts.table.row.data', compact('table', 'record', 'column'))
		@endif
	@endforeach
</tr>

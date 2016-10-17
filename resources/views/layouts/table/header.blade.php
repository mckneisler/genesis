<th class="{{ $column['size'] }} {{ array_has($column, 'align') ? $column['align'] : 'w3-left-align' }}">
	@if (array_has($column, 'sort'))
		@include('layouts.table.header.sort', compact('column'))
	@else
		{{ $column['heading'] }}
	@endif
</th>

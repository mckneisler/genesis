<td class="{{ array_has($column, 'align') ? $column['align'] : 'w3-left-align' }}">
	@if ( ! is_null($record->deleted_at) && ! (array_has($column, 'type') && $column['type'] == 'actions'))
		<i><strong>
	@endif
	@if (array_has($column, 'type'))
		@if ($column['type'] == 'checkbox')
			@if ($line)
				{? $line .= config('custom.delimiter'); ?}
			@endif
			@if ($record->{$column['field']})
				{? $line .= "x"; ?}
			@else
				{? $line .= " "; ?}
			@endif
			@include('layouts.table.row.data.checkbox', compact('record', 'column'))
		@elseif ($column['type'] == 'actions')
			{? $showActions = false; ?}
			@foreach ($column['links'] as $id => $link)
				{? $showLink = determineShowLink($link, $record); ?}
				{? $column['links'][$id]['showLink'] = $showLink; ?}
				@if ($showLink)
					{? $showActions = true; ?}
				@endif
			@endforeach

			@if ($showActions)
				@include('layouts.table.row.data.links', compact('record', 'column'))
				@include('layouts.button.links', compact('record', 'column'))
			@else
				&nbsp;
			@endif
		@endif
	@else
		@if ($line)
			{? $line .= config('custom.delimiter'); ?}
		@endif
		@if (array_has($column, 'table'))
			{? $line .= quote($record->{$column['table']}->{$column['field']}); ?}
		@else
			{? $line .= quote($record->{$column['field']}); ?}
		@endif
		@if (array_has($column, 'choose'))
			@if (array_has($column, 'table'))
				{{ choose($record->{$column['table']}->{$column['field']}, $column['choose']) }}
			@else
				{{ choose($record->{$column['field']}, $column['choose']) }}
			@endif
		@else
			@if (array_has($column, 'table'))
				{{ $record->{$column['table']}->{$column['field']} }}
			@elseif (array_has($column, 'listField'))
				{{ implode(', ', $record->{$column['field']}->lists('name')->toArray()) }}
			@else
				{{ $record->{$column['field']} }}
			@endif
		@endif
	@endif
	@if ( ! is_null($record->deleted_at) && ! (array_has($column, 'type') && $column['type'] == 'actions'))
		</strong></i>
	@endif
</td>

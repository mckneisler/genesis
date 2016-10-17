<span>
	<input
		type="checkbox"
		class="w3-check"
		onclick="{!! vsprintf($column['onclick'], array_only($record->toArray(), $column['subFields'])) !!}"
		@if ($record->{$column['field']})
			checked
		@endif
	>
	<span class="w3-hide" id="{{ vsprintf($column['spanId'], array_only($record->toArray(), $column['subFields'])) }}">&nbsp;</span>
</span>

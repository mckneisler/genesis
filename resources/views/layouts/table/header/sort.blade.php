<a
	class="underline"
	@if ($column['sort']['name'] == request()->sort)
		@if ( ! request()->has('order') || request()->order == 'asc')
			onclick="refreshWith('sort', '{{ $column['sort']['name'] }}:desc')"
		@else
			onclick="refreshWith('sort', '{{ $column['sort']['name'] }}:asc')"
		@endif
	@else
		onclick="refreshWith('sort', '{{ $column['sort']['name'] }}:{{ $column['sort']['order'] }}')"
	@endif
>
	@if ($column['sort']['name'] == request()->sort)
		<em>
	@endif

	{{ $column['heading'] }}

	@include('layouts.table.header.sort.icon', compact('column'))
</a>

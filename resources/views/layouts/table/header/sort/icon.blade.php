@if ($column['sort']['name'] == request()->sort)
	@if ( ! request()->has('order') || request()->order == 'asc')
		<i class="fa fa-sort-asc"></i>
	@else
		<i class="fa fa-sort-desc"></i>
	@endif
	</em>
@else
	<i class="fa fa-sort"></i>
@endif

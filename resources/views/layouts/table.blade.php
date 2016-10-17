@inject('carbon', 'Carbon\Carbon')

<form id='refresh'>
	<input type="hidden" name="search" id="search" value="{{ request()->search }}">
	@if (request()->has('sort'))
		<input type="hidden" name="sort" id="sort" value="{{ request()->sort }}">
	@endif
	@if (request()->has('order'))
		<input type="hidden" name="order" id="order" value="{{ request()->order }}">
	@endif
	@if (request()->has('status'))
		<input type="hidden" name="status" id="status" value="{{ request()->status }}">
	@endif
	@foreach ($table['columns'] as $column)
		@if (( ! array_has($column, 'condition') || $column['condition']) && array_has($column, 'filter'))
			<input
				type="hidden"
				name="{{ $column['filter']['name'] }}"
				id="{{ $column['filter']['name'] }}"
				value="{{ request()->{$column['filter']['name']} }}"
			>
		@endif
	@endforeach
</form>
<div id="{{ $table['name'] }}TableSwipeTop" class="{{ config('class.swipe') }}">
	<strong><i class="fa fa-backward"></i> {{ trans('phrase.swipe') }} <i class="fa fa-forward"></i></strong>
</div>

{? $filename = $table['name'] . $carbon::now()->format('Ymdhis') . substr(microtime(), 2, 8) . ".csv"; ?}
{? $filepath = public_path(). "/download/" . $filename; ?}
{? $file = fopen($filepath, 'w'); ?}
<div class="{{ config('class.tableDiv') }}">
	<table id="{{ $table['name'] }}Table" class="w3-table w3-striped w3-bordered">
		<thead>
			<tr class="w3-theme-l3">
				{? $line = ""; ?}
				@foreach ($table['columns'] as $col_id => $column)
					{{-- If none of the records in the table have actions, then remove the actions column --}}
					@if (array_has($column, 'type') && $column['type'] == 'actions')
						{? $showActions = false; ?}
						@foreach ($table['query'] as $record)
							@if(!$showActions)
								@foreach ($column['links'] as $id => $link)
									{? $showLink = determineShowLink($link, $record); ?}
									@if ($showLink)
										{? $showActions = true; ?}
										{? break; ?}
									@endif
								@endforeach
							@endif
							@if($showActions)
								{? break; ?}
							@endif
						@endforeach
						@if (array_has($column, 'condition'))
							{? $column['condition'] = $column['condition'] && $showActions; ?}
						@else
							{? $column['condition'] = $showActions; ?}
						@endif
						{? $table['columns'][$col_id]['condition'] = $column['condition']; ?}
						@if (!$column['condition'])
							{? $table['colspan'] = $table['colspan'] - 1; ?}
						@endif
					@endif

					@if ( ! array_has($column, 'condition') || $column['condition'])
						@if ( ! array_has($column, 'type') || $column['type'] != 'actions')
							@if ($line)
								{? $line .= config('custom.delimiter'); ?}
							@endif
							{? $line .= $column['heading']; ?}
						@endif
						@include('layouts.table.header', compact('column'))
					@endif
				@endforeach
				{? fwrite($file, "$line\n"); ?}
			</tr>
		</thead>

		<tbody>
			@if (array_has($table, 'filters') && $table['filters'])
				@include('layouts.table.filters', compact('table'))
			@endif
			@if ($table['query']->count())
				@foreach ($table['query'] as $record)
					{? $line = ""; ?}
					@include('layouts.table.row', compact('table', 'record'))
					{? fwrite($file, "$line\n"); ?}
				@endforeach
			@else
				<tr class="center">
					<td colspan="{{ $table['colspan'] }}" class="w3-center">{{ trans('phrase.noRecords') }}</td>
				</tr>
			@endif
		</tbody>
		<tfoot>
			{? fclose($file); ?}
			<tr class="w3-theme-l3">
				<td colspan="{{ $table['colspan'] }}">
					@if ($table['query']->count())
						&nbsp;
{{--
						{{ trans('action.download') }}: <a href="\download\{{ $filename }}">{{ $filename }}</a>
--}}
					@else
						&nbsp;
					@endif
				</td>
			</tr>
		</tfoot>
	</table>
</div>

<div id="{{ $table['name'] }}TableSwipeBottom" class="{{ config('class.swipe') }}">
	<strong><i class="fa fa-backward"></i> {{ trans('phrase.swipe') }} <i class="fa fa-forward"></i></strong>
</div>

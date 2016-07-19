@inject('carbon', 'Carbon\Carbon')

<form id='refresh'>
	<input type="hidden" name="search" id="search" value="{{ request()->search }}">
	@if (request()->has('sort'))
		<input type="hidden" name="sort" id="sort" value="{{ request()->sort }}">
	@endif
	@if (request()->has('order'))
		<input type="hidden" name="order" id="order" value="{{ request()->order }}">
	@endif
	@foreach ($table['columns'] as $column)
		@if ((!array_has($column, 'condition') || $column['condition']) && array_has($column, 'filter'))
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
				@foreach ($table['columns'] as $column)
					@if (!array_has($column, 'condition') || $column['condition'])
						@if (!array_has($column, 'type') || $column['type'] != 'actions')
							@if ($line)
								{? $line .= config('custom.delimiter'); ?}
							@endif
							{? $line .= $column['heading']; ?}
						@endif
						<th
							class="{{ $column['size'] }} {{ array_has($column, 'align') ? $column['align'] : 'w3-left-align' }}"
						>
							@if (array_has($column, 'sort'))
								<a
									class="underline"
									@if ($column['sort']['name'] == request()->sort)
										@if (!request()->has('order') || request()->order == 'asc')
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
								@if ($column['sort']['name'] == request()->sort)
									@if (!request()->has('order') || request()->order == 'asc')
										<i class="fa fa-sort-asc"></i>
									@else
										<i class="fa fa-sort-desc"></i>
									@endif
									</em>
								@else
									<i class="fa fa-sort"></i>
								@endif
								</a>
							@else
								{{ $column['heading'] }}
							@endif
						</th>
					@endif
				@endforeach
				{? fwrite($file, "$line\n"); ?}
			</tr>
		</thead>
		<tbody>
			@if (array_has($table, 'filters') && $table['filters'])
				<tr>
					@foreach ($table['columns'] as $column)
						@if (!array_has($column, 'condition') || $column['condition'])
							<td>
								@if (array_has($column, 'filter'))
									@include('layouts.select', ['select' => $column['filter']])
								@else
									&nbsp;
								@endif
							</td>
						@endif
					@endforeach
				</tr>
			@endif
			@if ($table['query']->count())
				@foreach ($table['query'] as $record)
					{? $line = ""; ?}
					<tr class="w3-hover-theme-l4">
						@foreach ($table['columns'] as $column)
							@if (!array_has($column, 'condition') || $column['condition'])
								<td class="{{ array_has($column, 'align') ? $column['align'] : 'w3-left-align' }}">
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
									@elseif ($column['type'] == 'actions')
										<div class="w3-hide-small">
											@foreach ($column['links'] as $link)
												@if (!array_has($link, 'condition') || $link['condition'])
													[<a href="{{ vsprintf($link['href'], array_only($record->toArray(), $link['subFields'])) }}">{{ $link['text'] }}</a>]
												@endif
											@endforeach
										</div>
										<div class="w3-hide-medium w3-hide-large dropdown">
											<button class="btn dropdown-toggle w3-theme" type="button" data-toggle="dropdown">
												{{ trans('action.select') }} <span class="caret"></span>
											</button>
											<ul class="dropdown-menu dropdown-menu-right w3-theme-l5">
												@foreach ($column['links'] as $link)
													@if (!array_has($link, 'condition') || $link['condition'])
														<li>
															<a
																href="{{ vsprintf($link['href'], array_only($record->toArray(), $link['subFields'])) }}"
																class="w3-hover-theme-l3"
															>
																{{ $link['text'] }}
															</a>
														</li>
													@endif
												@endforeach
											</ul>
										</div>
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
									@if (array_has($column, 'table'))
										{{ $record->{$column['table']}->{$column['field']} }}
									@else
										{{ $record->{$column['field']} }}
									@endif
								@endif
								</td>
							@endif
						@endforeach
					</tr>
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
						{{ trans('action.download') }}: <a href="\download\{{ $filename }}">{{ $filename }}</a>
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

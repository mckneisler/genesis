<div class="w3-hide-medium w3-hide-large dropdown w3-margin-left">
	<button class="dropdown-toggle {{ config('class.dropdown_button') }}" type="button" data-toggle="dropdown">
		{{ trans('action.select') }} <span class="caret"></span>
	</button>
	<ul class="dropdown-menu dropdown-menu-right">
		@foreach ($column['links'] as $link)
			@if ($link['showLink'])
				<li>
					@if (array_has($link, 'subPathId'))
						<a
							href="{{ vsprintf($link['href'], code()->getPathFromId($record->{$link['subPathId']})) }}"
							class="w3-theme-l2 w3-hover-theme-l4"
						>
							{{ $link['text'] }}
						</a>
					@else
						<a
							href="{{ vsprintf($link['href'], array_only($record->toArray(), $link['subFields'])) }}"
							class="w3-theme-l2 w3-hover-theme-l4"
						>
							{{ $link['text'] }}
						</a>
					@endif
				</li>
			@endif
		@endforeach
	</ul>
</div>

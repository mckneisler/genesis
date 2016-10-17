<div class="w3-hide-small">
	@foreach ($column['links'] as $link)
		@if ($link['showLink'])
			@if (array_has($link, 'subPathId'))
				[<a href="{{ vsprintf($link['href'], code()->getPathFromId($record->{$link['subPathId']})) }}">{{ $link['text'] }}</a>]
			@else
				[<a href="{{ vsprintf($link['href'], array_only($record->toArray(), $link['subFields'])) }}">{{ $link['text'] }}</a>]
			@endif
		@endif
	@endforeach
</div>

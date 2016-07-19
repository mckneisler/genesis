<a
{{--
--}}
	href="{{ $item['url'] }}"
	id="{{ $item['id'] }}"
	title="{{ $item['title'] }}"
	class="{{ set_active($item['id'], $level) }}"
>
	{!! $item['text'] !!}
	@if (array_has($item, 'submenu'))
		<span class="caret"></span>
	@endif
</a>

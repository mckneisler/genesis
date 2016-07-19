<a
	href="{{ $item['url'] }}"
	class="{{ set_active($item['id'], $level) }} {{ $align }}"
	title="{{ $item['title'] }}"
>
	{{ $item['text'] }}
</a>

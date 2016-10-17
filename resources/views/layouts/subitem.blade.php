<a
	href="{{ $item['url'] }}"
	class="{{ setActive($item['id'], $level) }} {{ $align }}"
	title="{{ $item['title'] }}"
>
	{{ $item['text'] }}
</a>

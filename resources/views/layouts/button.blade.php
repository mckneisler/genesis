@if(isset($button))
	{? extract($button) ?}
@endif

@if (isset($type) && $type == 'link')
	<a href="{{ $href }}" class="{{ config('class.button') }}">
		@if (isset($icon))
			<i class="fa fa-btn {{ $icon }}"></i>
		@endif
		{{ $label }}
	</a>
@else
	<button type="submit" class="{{ config('class.button') }}">
		@if (isset($icon))
			<i class="fa fa-btn {{ $icon }}"></i>
		@endif
		{{ $label or trans('action.' . $name) }}
	</button>
@endif

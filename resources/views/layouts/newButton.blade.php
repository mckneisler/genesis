<form action="{{ $url }}">
	@if (isset($params) && count($params))
		@foreach ($params as $name => $value)
			<input type="hidden" name="{{ $name }}" value="{{ $value }}">
		@endforeach
	@endif
	<button type="submit" class="{{ config('class.button') }} w3-margin-left pull-right">
		<i class="fa fa-btn fa-plus-circle"></i>
		{{ $text }}
	</button>
</form>

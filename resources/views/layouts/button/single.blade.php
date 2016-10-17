<div class="form-group">
	<div class="{{ config('class.buttonDiv') }}">
		@include('layouts.button')
		@if (config('custom.style') == 'bootstrap' && isset($linkUrl) && isset($linkPhrase))
			<a class="btn btn-link" href="{{ url($linkUrl) }}">{{ $linkPhrase }}</a>
		@endif
	</div>
</div>
@if (config('custom.style') == 'w3' && isset($linkUrl) && isset($linkPhrase))
	<div class="form-group">
		<div class="{{ config('class.buttonDiv') }} w3-padding-0">
			<a class="btn btn-link w3-right" href="{{ url($linkUrl) }}">{{ $linkPhrase }}</a>
		</div>
	</div>
@endif

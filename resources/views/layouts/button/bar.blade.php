<div class="form-group">
	<div class="{{ config('class.buttonDiv') }}">
		<div class="btn-toolbar">
			@if (config('custom.style') == 'w3')
				@foreach(array_reverse($buttons) as $button)
					@include('layouts.button', compact('button'))
				@endforeach
			@else
				@foreach($buttons as $button)
					@include('layouts.button', compact('button'))
				@endforeach
			@endif
		</div>
	</div>
</div>

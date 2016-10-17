<fieldset class="{{ config('class.fieldset') }}">
	<legend class='w3-text-theme'>{{ $name }}</legend>

	@foreach ($options as $option)
		@include('layouts.options', [
			'option' => $option
		])
	@endforeach
</fieldset>

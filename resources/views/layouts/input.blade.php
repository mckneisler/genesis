@if (isset($disabled) && $disabled)
	<input type="hidden" name="{{ $name }}" value="{{ oldModelValue($name, $model) }}">
@endif
@if (isset($type) && $type == 'checkbox')
	<div class="form-group">
		@include('layouts.input.checkbox', compact('type', 'name', 'label'))
	</div>
@else
	<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
		@unless(config('custom.label_position') == 'bottom')
			@include('layouts.input.label', compact('name', 'label'))
		@endunless

		<div class="{{ config('class.inputDiv') }}">
			@if (isset($type) && ! in_array($type, ['text', 'password']))
				@if ($type == 'select')
					@include('layouts.input.select', [
						'select' => compact(
							'name',
							'values',
							'nullText',
							'value',
							'text',
							'disabled',
							'onchange',
							'onload'
						)
					])
				@elseif ($type == 'multiselect')
					@include('layouts.input.multiselect', [
						'select' => compact(
							'name',
							'values',
							'value',
							'text',
							'disabled',
							'onchange'
						)
					])
				@elseif ($type == 'textarea')
					@include('layouts.input.textarea', compact('name', 'row', 'model'))
				@endif
			@else
				<input
					id="{{ $name }}"
					name="{{ $name }}"
					type="{{ $type or 'text' }}"
					class="{{ config('class.input') }}"
					@if ( ! isset($type) || $type != 'password')
						value="{{ oldModelValue($name, defaultValue($model)) }}"
					@endif
				>
			@endif

			@if ($errors->has($name))
				<span class="help-block">
					<strong>{{ $errors->first($name) }}</strong>
				</span>
			@endif
		</div>

		@if(config('custom.label_position') == 'bottom')
			@include('layouts.input.label', compact('name', 'label'))
		@endif
	</div>
@endif

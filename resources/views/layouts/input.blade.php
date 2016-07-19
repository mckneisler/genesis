@if (isset($type) && $type == 'checkbox')
	<div class="form-group">
		<div class="{{ config('class.buttonDiv') }}">
			<div class="{{ $type }}">
				<label>
					<input type="{{ $type }}" name="{{ $name }}"> {{ $label or trans('phrase.' . $name) }}
				</label>
			</div>
		</div>
	</div>
@elseif (isset($type) && $type == 'button')
	<div class="form-group">
		<div class="{{ config('class.buttonDiv') }}">
			<button type="submit" class="{{ config('class.button') }}">
				@if (isset($icon))
					<i class="fa fa-btn {{ $icon }}"></i>
				@endif
				{{ $label or trans('action.' . $name) }}
			</button>
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
@else
	<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
		@unless(config('custom.labelPosition') == 'bottom')
			<label for="{{ $name }}" class="{{ config('class.label') }}">
				{{ $label or trans('object.' . $name) }}
			</label>
		@endunless

		<div class="{{ config('class.inputDiv') }}">
			@if (isset($type) && $type == 'select')
				@include('layouts.select', ['select' => compact(
					'name',
					'values',
					'nullText',
					'value',
					'text'
				)])
			@else
				<input
					id="{{ $name }}"
					type="{{ $type or 'text' }}"
					class="{{ config('class.input') }}"
					name="{{ $name }}"
					@if (!isset($type) || $type != 'password')
						value="{{ old($name, isset($model) ? $model->{$name} : null) }}"
					@endif
				>
			@endif

			@if ($errors->has($name))
				<span class="help-block">
					<strong>{{ $errors->first($name) }}</strong>
				</span>
			@endif
		</div>

		@if(config('custom.labelPosition') == 'bottom')
			<label for="{{ $name }}" class="{{ config('class.label') }}">
				{{ $label or trans('object.' . $name) }}
			</label>
		@endif
	</div>
@endif

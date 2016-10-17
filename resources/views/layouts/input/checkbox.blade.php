<div class="{{ config('class.buttonDiv') }}">
	<div class="{{ $type }}">
		<label>
			<input
				type="{{ $type }}"
				name="{{ $name }}"
				@if (determineChecked($name, defaultValue($model), defaultValue($condition), defaultValue($conditionField)))
					checked
				@endif
			>
			<span class="checkbox-label">{{ $label or trans('phrase.' . $name) }}</span>
		</label>
	</div>
</div>

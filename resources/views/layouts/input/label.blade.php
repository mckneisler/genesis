<label for="{{ $name }}" class="{{ config('class.label') }}">
	{{ $label or choose(code('objects.' . $name)->name, 1) }}
</label>

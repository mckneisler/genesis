<textarea
	name="{{ $name }}"
	id="{{ $name }}"
	class="{{ config('class.input') }}"
	rows="{{ $rows or 3 }}"
>{{ oldModelValue($name, defaultValue($model)) }}</textarea>

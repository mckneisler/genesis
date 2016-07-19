@section('formContent')
	<input type="hidden" id="setFocusId" value="{{ count($errors) ? $errors->keys()[0] : 'name' }}" />

	@include('layouts.input', ['name' => 'name'])

	@include('layouts.input', [
		'name' => 'submit',
		'type' => 'button',
		'icon' => 'fa-plus-circle',
		'label' => $submitButtonText
	])
@endsection

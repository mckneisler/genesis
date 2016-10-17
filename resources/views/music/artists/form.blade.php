@section('formContent')
	<input type="hidden" id="set_focus_id" value="{{ count($errors) ? $errors->keys()[0] : 'name' }}" />
	<input type="hidden" name="id" value="{{ oldModelValue('id', defaultValue($model)) }}">

	@include('layouts.input', ['name' => 'name'])

	@include('layouts.button.bar.saveCancel', ['default' => '/music/artists'])
@endsection

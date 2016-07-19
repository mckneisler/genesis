@section('formContent')
	<input type="hidden" id="setFocusId" value="{{ count($errors) ? $errors->keys()[0] : 'artist_id' }}" />

	@include('layouts.input', [
		'name' => 'artist_id',
		'type' => 'select',
		'label' => trans_choice('object.artist', 1),
		'values' => $artists,
		'nullText' => trans('phrase.selectOne'),
		'value' => 'id',
		'text' => 'name'
	])

	@include('layouts.input', ['name' => 'name'])

	@include('layouts.input', [
		'name' => 'submit',
		'type' => 'button',
		'icon' => 'fa-plus-circle',
		'label' => $submitButtonText
	])
@endsection

@section('formContent')
	<input type="hidden" id="set_focus_id" value="{{ count($errors) ? $errors->keys()[0] : 'artist_id' }}" />
	<input type="hidden" name="id" value="{{ oldModelValue('id', defaultValue($model)) }}">

	@include('layouts.input', [
		'name' => 'artist_id',
		'type' => 'select',
		'label' => choose(code('objects.artists')->name, 1),
		'values' => $artists,
		'nullText' => trans('phrase.selectOne'),
		'value' => 'id',
		'text' => 'name'
	])

	@include('layouts.input', [
		'name' => 'album_id',
		'type' => 'select',
		'label' => choose(code('objects.albums')->name, 1),
		'values' => $albums,
		'nullText' => trans('phrase.selectOne'),
		'value' => 'id',
		'text' => 'name'
	])

	@include('layouts.input', ['name' => 'name'])

	@include('layouts.button.bar.saveCancel', ['default' => '/music/songs'])
@endsection

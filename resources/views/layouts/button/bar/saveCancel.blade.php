@include('layouts.button.bar', [
	'buttons' => [
		'submit' => [
			'name' => 'submit',
			'icon' => 'fa-floppy-o',
			'label' => code('actions.save')->name
		],
		'cancel' => [
			'type' => 'link',
			'href' => isset($no_back) && $no_back ? $default : session()->get('url.back', $default),
			'icon' => 'fa-times-circle',
			'label' => code('actions.cancel')->name
		]
	]
])

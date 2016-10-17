@extends('layouts.app')

@section('content')
	@include('layouts.table.title', compact('type'))

	<div class="w3-container w3-section w3-padding-0 clearfix">
		@if(Auth::guest())
			@include ('layouts.favsInstruction')
		@else
			@include ('layouts.button.new', [
				'url' => '/music/artists/create',
				'text' => code('actions.new')->name
			])
		@endif
		@include('layouts.search')
	</div>

	@include('layouts.table', ['table' => [
		'name' => 'artists',
		'query' => $artists,
		'colspan' => Auth::check() ? '3' : '2',
		'filters' => Auth::check(),
		'columns' => [
			'artist' => [
				'heading' => choose(code('objects.artists')->name, 1),
				'size' => Auth::check() ? 'col-xs-9' : 'col-xs-10',
				'field' => 'artist_name',
				'sort' => [
					'name' => 'artist',
					'order' => 'asc'
				]
			],
			'favorite' => [
				'heading' => choose(code('objects.favorite')->name, 1),
				'size' => 'col-xs-1',
				'align' => 'w3-center',
				'type' => 'checkbox',
				'onclick' => 'changeFavorite(\'artists\', %s, ' . (Auth::check() ? Auth::user()->id : 0) . ', this.checked);',
				'spanId' => 'return_%s',
				'subFields' => [
					'id'
				],
				'field' => 'users_count',
				'condition' => Auth::check(),
				'sort' => [
					'name' => 'favorite',
					'order' => 'desc'
				],
				'filter' => [
					'values' => $favorites,
					'nullText' => trans('phrase.all'),
					'name' => 'fave',
					'onchange' => 'refreshWith(this.name, this.value)'
				]
			],
			'actions' => [
				'heading' => choose(code('objects.actions')->name, 1),
				'size' => 'col-xs-2',
				'align' => 'w3-center',
				'type' => 'actions',
				'links' => [
					'albums' => [
						'href' => '/music/albums?artist_id=%s',
						'subFields' => [
							'id'
						],
						'text' => choose(code('objects.albums')->name, 2)
					],
					'songs' => [
						'href' => '/music/songs?artist_id=%s',
						'subFields' => [
							'id'
						],
						'text' => choose(code('objects.songs')->name, 2)
					],
					'edit' => [
						'condition' => Auth::check(),
						'href' => '/music/artists/%s/edit',
						'subFields' => [
							'id'
						],
						'text' => code('actions.edit')->name
					]
				]
			]
		]
	]])
@endsection

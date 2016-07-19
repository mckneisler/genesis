@extends('layouts.app')

@section('content')
	<div class="w3-container w3-section w3-padding-0 clearfix">
		@if(Auth::guest())
			@include ('layouts.favsInstruction')
		@else
			@include ('layouts.newButton', [
				'url' => '/music/albums/create',
				'text' => trans('phrase.newObject', ['object' => trans_choice('object.album', 1)]),
				'params' => $defaults
			])
		@endif
		@include('layouts.search')
	</div>

	@include('layouts.table', ['table' => [
		'name' => 'albums',
		'query' => $albums,
		'colspan' => Auth::check() ? '4' : '3',
		'filters' => true,
		'columns' => [
			'artist' => [
				'heading' => trans_choice('object.artist', 1),
				'size' => Auth::check() ? 'col-xs-5' : 'col-xs-5',
				'field' => 'artist_name',
				'sort' => [
					'name' => 'artist',
					'order' => 'asc'
				],
				'filter' => [
					'values' => $artists,
					'nullText' => trans('phrase.allObjects', ['objects' => trans_choice('object.artist', 2)]),
					'name' => 'artist_id',
					'onchange' => 'refreshWith(this.name, this.value)'
				]
			],
			'album' => [
				'heading' => trans_choice('object.album', 1),
				'size' => Auth::check() ? 'col-xs-4' : 'col-xs-5',
				'field' => 'album_name',
				'sort' => [
					'name' => 'album',
					'order' => 'asc'
				]
			],
			'favorite' => [
				'heading' => trans('object.favorite'),
				'size' => 'col-xs-1',
				'align' => 'w3-center',
				'type' => 'checkbox',
				'onclick' => 'changeFavorite(\'albums\', %s, ' . (Auth::check() ? Auth::user()->id : 0) . ', this.checked);',
				'spanId' => 'return_%s',
				'subFields' => [
					'album_id'
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
				'heading' => trans('object.action') ,
				'size' => 'col-xs-2',
				'align' => 'w3-center',
				'type' => 'actions',
				'links' => [
					'songs' => [
						'href' => '/music/songs?album_id=%s',
						'subFields' => [
							'album_id'
						],
						'text' => trans_choice('object.song', 2)
					],
					'edit' => [
						'condition' => Auth::check(),
						'href' => '/music/albums/%s/edit',
						'subFields' => [
							'album_id'
						],
						'text' => trans('action.edit')
					]
				]
			]
		]
	]])
@endsection

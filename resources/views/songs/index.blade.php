@extends('layouts.app')

@section('content')
	<div class="w3-container w3-section w3-padding-0 clearfix">
		@if(Auth::guest())
			@include ('layouts.favsInstruction')
		@else
			@include ('layouts.newButton', [
				'url' => '/music/songs/create',
				'text' => trans('phrase.newObject', ['object' => trans_choice('object.song', 1)]),
				'params' => $defaults
			])
		@endif
		@include('layouts.search')
	</div>

	@include('layouts.table', ['table' => [
		'name' => 'songs',
		'query' => $songs,
		'colspan' => Auth::check() ? '5' : '3',
		'filters' => true,
		'columns' => [
			'artist' => [
				'heading' => trans_choice('object.artist', 1),
				'size' => Auth::check() ? 'col-xs-3' : 'col-xs-4',
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
				'size' => Auth::check() ? 'col-xs-3' : 'col-xs-4',
				'field' => 'album_name',
				'sort' => [
					'name' => 'album',
					'order' => 'asc'
				],
				'filter' => [
					'values' => $albums,
					'nullText' => trans('phrase.allObjects', ['objects' => trans_choice('object.album', 2)]),
					'name' => 'album_id',
					'onchange' => 'refreshWith(this.name, this.value)'
				]
			],
			'song' => [
				'heading' => trans_choice('object.song', 1),
				'size' => Auth::check() ? 'col-xs-4' : 'col-xs-4',
				'field' => 'song_name',
				'sort' => [
					'name' => 'song',
					'order' => 'asc'
				]
			],
			'favorite' => [
				'heading' => trans('object.favorite'),
				'size' => 'col-xs-1',
				'align' => 'w3-center',
				'type' => 'checkbox',
				'onclick' => 'changeFavorite(\'songs\', %s, ' . (Auth::check() ? Auth::user()->id : 0) . ', this.checked);',
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
				'heading' => trans('object.action') ,
				'size' => 'col-xs-1',
				'align' => 'w3-center',
				'type' => 'actions',
				'condition' => Auth::check(),
				'links' => [
					'edit' => [
						'condition' => Auth::check(),
						'href' => '/music/songs/%s/edit',
						'subFields' => [
							'id'
						],
						'text' => trans('action.edit')
					]
				]
			]
		]
	]])
@endsection

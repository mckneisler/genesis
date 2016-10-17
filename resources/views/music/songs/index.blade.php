@extends('layouts.app')

@section('content')
	@include('layouts.table.title', compact('type'))

	<div class="w3-container w3-section w3-padding-0 clearfix">
		@if(Auth::guest())
			@include ('layouts.favsInstruction')
		@else
			@include ('layouts.button.new', [
				'url' => '/music/songs/create',
				'text' => code('actions.new')->name,
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
				'heading' => choose(code('objects.artists')->name, 1),
				'size' => Auth::check() ? 'col-xs-3' : 'col-xs-4',
				'field' => 'artist_name',
				'sort' => [
					'name' => 'artist',
					'order' => 'asc'
				],
				'filter' => [
					'values' => $artists,
					'nullText' => trans('phrase.all'),
					'name' => 'artist_id',
					'onchange' => 'refreshWith(this.name, this.value)'
				]
			],
			'album' => [
				'heading' => choose(code('objects.albums')->name, 1),
				'size' => Auth::check() ? 'col-xs-3' : 'col-xs-4',
				'field' => 'album_name',
				'sort' => [
					'name' => 'album',
					'order' => 'asc'
				],
				'filter' => [
					'values' => $albums,
					'nullText' => trans('phrase.all'),
					'name' => 'album_id',
					'onchange' => 'refreshWith(this.name, this.value)'
				]
			],
			'song' => [
				'heading' => choose(code('objects.songs')->name, 1),
				'size' => Auth::check() ? 'col-xs-4' : 'col-xs-4',
				'field' => 'song_name',
				'sort' => [
					'name' => 'song',
					'order' => 'asc'
				]
			],
			'favorite' => [
				'heading' => choose(code('objects.favorite')->name, 1),
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
				'heading' => choose(code('objects.actions')->name, 1),
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
						'text' => code('actions.edit')->name
					]
				]
			]
		]
	]])
@endsection

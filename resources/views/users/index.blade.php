@extends('layouts.app')

@section('content')

	@include('layouts.table.title', compact('type'))
	<div class="w3-container w3-section w3-padding-0 clearfix">
		@if(Gate::allows('users-add'))
			@include ('layouts.button.new', [
				'url' => '/admin/security/users/create',
				'text' => code('actions.new')->name
			])
		@endif

		@include('layouts.button.status')

		@include('layouts.search')
	</div>

	@include('layouts.table', [
		'table' => [
			'name' => 'users',
			'query' => $users,
			'colspan' => 4,
			'filters' => true,
			'columns' => [
				'name' => [
					'heading' => choose(code('objects.name')->name, 1),
					'size' => 'col-xs-2',
					'field' => 'name',
					'sort' => [
						'name' => 'name',
						'order' => 'asc'
					]
				],
				'email' => [
					'heading' => choose(code('objects.email')->name, 1),
					'size' => 'col-xs-2',
					'field' => 'email',
					'sort' => [
						'name' => 'email',
						'order' => 'asc'
					]
				],
				'roles' => [
					'heading' => choose(code('objects.roles')->name, 2),
					'size' => 'col-xs-8',
					'field' => 'rolesWithLocale',
					'listField' => 'name',
					'filter' => [
						'values' => $roles,
						'nullText' => trans('phrase.all'),
						'name' => 'role',
						'onchange' => 'refreshWith(this.name, this.value)'
					]
				],
				'actions' => [
					'heading' => choose(code('objects.actions')->name, 1),
					'size' => 'col-xs-2',
					'align' => 'w3-center',
					'type' => 'actions',
					'links' => [
						'edit' => [
							'condition' => Gate::allows('users-edit'),
							'href' => '/admin/security/users/%s/edit',
							'subFields' => [
								'id'
							],
							'text' => code('actions.edit')->name
						]
					]
				]
			]
		]
	])
@endsection

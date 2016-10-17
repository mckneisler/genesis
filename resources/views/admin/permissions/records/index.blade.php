@extends('layouts.app')

@section('content')

	@include('layouts.button', [
		'type' => 'link',
		'name' => 'return',
		'icon' => 'fa-backward',
		'label' => trans('phrase.returnToObject', ['object' => choose(code('objects.permissions')->name, 2)]),
		'href' => '/admin/security/permissions'
	])

	<h2>{{ choose($permission->object_name, 1) }} - {{ choose($permission->action_name, 1) }}</h2>
	<p>{{ $permission->action_description }}</p>
	<p>{{ $permission->object_description }}</p>

	<div class="w3-container w3-section w3-padding-0 clearfix">
		@if(Gate::allows('records-add'))
			@include ('layouts.button.new', [
				'url' => '/admin/security/permissions/' . $permission->object_code . '-' . $permission->action_code . '/records/create',
				'text' => code('actions.new')->name
			])
		@endif

		@include('layouts.search')
	</div>

	@include('layouts.table', [
		'table' => [
			'name' => 'records',
			'query' => $records,
			'colspan' => 3,
			'filters' => true,
			'columns' => [
				'object' => [
					'heading' => choose(code('objects.records')->name, 1),
					'size' => 'col-xs-4',
					'choose' => 1,
					'field' => 'record_name',
					'sort' => [
						'name' => 'record',
						'order' => 'asc'
					]
				],
				'roles' => [
					'heading' => choose(code('objects.roles')->name, 2),
					'size' => 'col-xs-6',
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
							'condition' => Gate::allows('records-edit') || Gate::allows('records-edit_roles'),
							'href' => '/admin/security/permissions/' . $permission->object_code . '-' . $permission->action_code . '/records/%s/edit',
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

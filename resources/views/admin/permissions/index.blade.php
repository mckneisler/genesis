@extends('layouts.app')

@section('content')

	@include('layouts.table.title', compact('type'))
	<div class="w3-container w3-section w3-padding-0 clearfix">
		@if(Gate::allows('permissions-add'))
			@include ('layouts.button.new', [
				'url' => '/admin/security/permissions/create',
				'text' => code('actions.new')->name
			])
		@endif

		@include('layouts.search')
	</div>

	@include('layouts.table', [
		'table' => [
			'name' => 'permissions',
			'query' => $permissions,
			'colspan' => 4,
			'filters' => true,
			'columns' => [
				'object' => [
					'heading' => choose(code('objects.objects')->name, 1),
					'size' => 'col-xs-2',
					'choose' => 1,
					'field' => 'object_name',
					'sort' => [
						'name' => 'object',
						'order' => 'asc'
					],
					'filter' => [
						'values' => $objects,
						'nullText' => trans('phrase.all'),
						'name' => 'object',
						'onchange' => 'refreshWith(this.name, this.value)'
					]
				],
				'action' => [
					'heading' => choose(code('objects.actions')->name, 1),
					'size' => 'col-xs-2',
					'choose' => 1,
					'field' => 'action_name',
					'sort' => [
						'name' => 'action',
						'order' => 'asc'
					],
					'filter' => [
						'values' => $actions,
						'nullText' => trans('phrase.all'),
						'name' => 'action',
						'onchange' => 'refreshWith(this.name, this.value)'
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
							'condition' => Gate::allows('permissions-edit') || Gate::allows('permissions-edit_roles'),
							'href' => '/admin/security/permissions/%s-%s/edit',
							'subFields' => [
								'object_code',
								'action_code'
							],
							'text' => code('actions.edit')->name
						],
						'records' => [
							'condition' => Gate::allows('records-list'),
							'conditionIsTableOrCodeField' => 'object_code',
							'href' => '/admin/security/permissions/%s-%s/records',
							'subFields' => [
								'object_code',
								'action_code'
							],
							'text' => choose(code('objects.records')->name, 2)
						]
					]
				]
			]
		]
	])
@endsection

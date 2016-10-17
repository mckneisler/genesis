@extends('layouts.app')

@section('content')

	@if ($type->code != 'types')
		@include('layouts.button', [
			'type' => 'link',
			'name' => 'return',
			'icon' => 'fa-backward',
			'label' => trans('phrase.returnToObject', ['object' => choose($parent->name, 2)]),
			'href' => '/admin/' . code()->getPathFromId($parent->id) . '/codes'
		])
	@endif

	@include('layouts.table.title', compact('type'))
	<div class="w3-container w3-section w3-padding-0 clearfix">
		@if(Gate::allows('codes-add', $type->id))
			@include ('layouts.button.new', [
				'url' => '/admin/' . code()->getPathFromId($type->id) . '/codes/create',
				'text' => code('actions.new')->name
			])
		@endif

		@include('layouts.button.status')

		@include('layouts.search')
	</div>

	@include('layouts.table', [
		'table' => [
			'name' => 'codes',
			'query' => $codes,
			'colspan' => 4,
			'filters' => false,
			'has_status' => true,
			'columns' => [
				'code' => [
					'heading' => choose(code('objects.codes')->name, 1),
					'size' => 'col-xs-2',
					'field' => 'code',
					'sort' => [
						'name' => 'code',
						'order' => 'asc'
					]
				],
				'name' => [
					'heading' => choose(code('objects.name')->name, 1),
					'size' => 'col-xs-4',
					'choose' => 1,
					'field' => 'name',
					'sort' => [
						'name' => 'name',
						'order' => 'asc'
					]
				],
				'description' => [
					'heading' => choose(code('objects.description')->name, 1),
					'size' => 'col-xs-5',
					'field' => 'description',
					'sort' => [
						'name' => 'desc',
						'order' => 'asc'
					]
				],
				'actions' => [
					'heading' => choose(code('objects.actions')->name, 1),
					'size' => 'col-xs-1',
					'align' => 'w3-center',
					'type' => 'actions',
					'links' => [
						'list' => [
							'conditionField' => 'children_count',
							'conditionAllows' => 'codes-list',
							'href' => '/admin/%s/codes',
							'subPathId' => 'id',
							'text' => code('actions.list')->name
						],
						'edit' => [
							'conditionAllows' => 'codes-edit',
							'conditionAllowsValue' => $type->id,
							'href' => '/admin/' . code()->getPathFromId($type->id) . '/codes/%s/edit',
							'subFields' => [
								'code'
							],
							'text' => code('actions.edit')->name
						],
						'new' => [
							'conditionNotField' => 'children_count',
							'conditionAllows' => 'codes-add_child',
							'href' => '/admin/' . code()->getPathFromId($type->id) . ':%s/codes/create',
							'subFields' => [
								'code'
							],
							'text' => code('actions.add')->name
						],
						'permissions' => [
							'condition' => $type->code == 'roles',
							'conditionAllows' => 'permissions-list',
							'href' => '/admin/security/permissions?role=%s',
							'subFields' => [
								'code'
							],
							'text' => choose(code('objects.permissions')->name, 2)
						],
						'users' => [
							'condition' => $type->code == 'roles',
							'conditionAllows' => 'users-list',
							'href' => '/admin/security/users?role=%s',
							'subFields' => [
								'code'
							],
							'text' => choose(code('objects.users')->name, 2)
						]
					]
				]
			]
		]
	])
@endsection

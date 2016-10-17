@extends('layouts.form', [
	'title' => choose(code('objects.permissions')->name, 1),
	'url' => url('/admin/security/permissions/' . $permission->object_code . '-' . $permission->action_code),
	'method' => 'PATCH',
	'model' => $permission
])

@include('admin.permissions.form', [
	'mode' => 'edit',
	'model' => $permission
])

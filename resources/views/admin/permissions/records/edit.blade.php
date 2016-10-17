@extends('layouts.form', [
	'title' => choose($permission->object_name, 1) . ' - ' . choose($permission->action_name, 1),
	'url' => url('/admin/security/permissions/' . $permission->object_code . '-' . $permission->action_code . '/records/' . $permission_record->id),
	'method' => 'PATCH',
	'model' => $permission_record
])

@include('admin.permissions.records.form', [
	'mode' => 'edit',
	'model' => $permission_record
])

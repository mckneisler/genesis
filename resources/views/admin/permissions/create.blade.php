@extends('layouts.form', [
	'title' => choose(code('objects.permissions')->name, 1),
	'url' => url('/admin/security/permissions')
])

@include('admin.permissions.form', [
	'mode' => 'create',
])

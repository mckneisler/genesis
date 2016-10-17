@extends('layouts.form', [
	'title' => choose($type->name, 1),
	'url' => url('/admin/security/users')
])

@include('users.form', [
	'mode' => 'create',
])

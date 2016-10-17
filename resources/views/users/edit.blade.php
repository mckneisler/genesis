@extends('layouts.form', [
	'title' => choose($type->name, 1),
	'url' => url((in_array('admin', Request::segments()) ? '/admin/security/users/' : '/users/profile/') . $user->id),
	'method' => 'PATCH',
	'model' => $user
])

@include('users.form', [
	'mode' => 'edit',
	'model' => $user
])

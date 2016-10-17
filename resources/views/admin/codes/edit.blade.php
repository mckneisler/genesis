@extends('layouts.form', [
	'title' => choose($type->name, 1),
	'url' => url('/admin/' . code()->getPathFromId($type->id) . '/codes/' . $code->code),
	'method' => 'PATCH',
	'model' => $code
])

@include('admin.codes.form', [
	'mode' => 'edit',
	'model' => $code
])

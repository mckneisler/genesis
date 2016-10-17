@extends('layouts.form', [
	'title' => choose($type->name, 1),
	'url' => url('/admin/' . code()->getPathFromId($type->id) . '/codes')
])

@include('admin.codes.form', [
	'mode' => 'create',
])

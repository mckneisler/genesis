<?php

use Illuminate\Support\Facades\App;

function set_active($id, $level = 1)
{
	switch ($level) {
		case 1:
			return Request::segment($level) == $id ? 'w3-theme-d3' : 'w3-theme w3-hover-theme-l3';
		case 2:
			return Request::segment($level) == $id ? 'w3-theme-d1' : 'w3-theme-l2 w3-hover-theme-l4';
		case 3:
			return Request::segment($level) == $id ? 'w3-theme' : 'w3-theme-l4 w3-hover-theme-l3';
		default:
			break;
	}
}

function flash($title = null, $message = null)
{
	$flash = app('App\Http\Flash');

	if (func_num_args() == 0) {
		return $flash;
	}

	return $flash->info($title, $message);
}

function quote($string, $double = false, $textQualifier = null)
{
	$textQualifier = isset($textQualifier) ? $textQualifier : config('custom.textQualifier');
	if ($double) {
		$replacement = $textQualifier . $textQualifier;
	} else {
		$replacement = '\\' . $textQualifier;
	}

	return $textQualifier . str_replace($textQualifier, $replacement, $string) . $textQualifier;
}

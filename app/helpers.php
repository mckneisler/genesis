<?php

use Illuminate\Support\Facades\App;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Carbon\Carbon;

use App\Models\Code;

define("PARSER_LIB_ROOT", __DIR__ . "/Libraries/sqlparser/");
include(PARSER_LIB_ROOT . 'sqlparser.lib.php');

/**
 * Return singular or plural version of a string
 *
 * @param string $text   	Pipe delimited string
 * @param mixed $number 	Integer or coutable variable
 * @param string $locale 	Locale code
 *
 * @return string
 */
function choose($text, $number, $locale = null)
{
	if (is_array($number) || $number instanceof \Countable) {
		$number = count($number);
	}

	$locale = $locale ?: App::getLocale();
	$selector = new MessageSelector;
	return $selector->choose($text, $number, $locale);
}

/**
 * Returns an instance of Code or a specific Code
 *
 * @param string $id     	Either code path with colons dot code or a code id
 * @param string $locale 	Locale code
 *
 * @return App\Models\Code
 */
function code($id = null, $locale = null)
{
	$code = app('App\Models\Code');

	if (func_num_args() == 0) {
		return $code;
	}

	return $code->getCode($id, $locale);
}

/**
 * Returns an instance of Code or a specific Code
 *
 * @param string $id     	Either code path with colons dot code or a code id
 * @param string $locale 	Locale code
 *
 * @return App\Models\Code
 */
function codePath($id, $field = 'code', $delimeter = '-')
{
	return Code::getPathFromId($id, $field, $delimeter);
}

/**
 * Determines if a string contains any of the values in an array
 *
 * @param string $str
 * @param array $arr
 *
 * @return bool
 */
function containsAnyFromArray($str, array $arr)
{
    foreach($arr as $a) {
        if (stripos($str,$a) !== false) return true;
    }
    return false;
}

/**
 * Formatted date action string
 *
 * @param int $user 	User id
 * @param unknown $date Date object
 *
 * @return string
 */
function datePhrase($user, $date)
{
	$phrase = '';
	if ( ! is_null($user)) {
		$phrase .= ' ' . trans('phrase.by') . ' ' . user($user)->name;
	}
	$phrase .= ' ' . trans('phrase.on') . ' ' . format($date);

	return $phrase;
}

/**
 * Verifies the existence of a variable or creates it with a default value
 *
 * @param mixed $variable Variable to check/set
 * @param mixed $default  Default value
 *
 * @return mixed
 */
function defaultValue(&$variable, $default = null)
{
	if ( ! isset($variable)) {
		$variable = $default;
	}

	return $variable;
}

/**
 * Determine if a checkbox should be checked
 *
 * @param string $name           		Name of the field
 * @param object $model          		Instance of a model
 * @param null|string|bool $condition	A condition to evaluate
 * @param string $conditionField 		A field in the model instance to be used in the coditional evaluation
 *
 * @return bool    						True when the checkbox should be checked
 */
function determineChecked($name, $model = null, $condition = null, $conditionField = null)
{
	$checked = false;

	if (is_null($conditionField)) {
		$field = oldModelValue($name, $model);
	} else {
		$field = oldModelValue($conditionField, $model);
	}

	switch (gettype($condition)) {
		case 'NULL':
			$checked = oldModelValue($name, $model);
			break;
		case 'string':
			switch ($condition) {
				case 'is_null':
					$checked = is_null($field);
					break;
				case '! is_null':
					$checked = ! is_null($field);
					break;
			}
	}

	return $checked;
}

/**
 * Determines if a link should be displayed
 *
 * @param array $link   	Array of link properties
 * @param object $record 	Instance of a model
 *
 * @return bool    			True if the link should be displayed
 */
function determineShowLink($link, $record)
{
	$showLink = true;
	if (array_has($link, 'condition') && ! $link['condition']) {
		$showLink = false;
	}
	if (array_has($link, 'conditionField') && ! $record->{$link['conditionField']}) {
		$showLink = false;
	}
	if (array_has($link, 'conditionNotField') && $record->{$link['conditionNotField']}) {
		$showLink = false;
	}
	if (array_has($link, 'conditionIsTableOrCodeField') && ! isTableOrCode($record->{$link['conditionIsTableOrCodeField']})) {
		$showLink = false;
	}
	if (array_has($link, 'conditionAllows') && ! array_has($link, 'conditionAllowsField') && ! array_has($link, 'conditionAllowsValue') && ! Gate::allows($link['conditionAllows'])) {
		$showLink = false;
	}
	if (array_has($link, 'conditionAllows') && array_has($link, 'conditionAllowsValue') && ! Gate::allows($link['conditionAllows'], $link['conditionAllowsValue'])) {
		$showLink = false;
	}
	if (array_has($link, 'conditionAllows') && array_has($link, 'conditionAllowsField') && ! Gate::allows($link['conditionAllows'], $record->{$link['conditionAllowsField']})) {
		$showLink = false;
	}

	return $showLink;
}

/**
 * Creates an instance of a flash and sets a message
 *
 * @param string $title   	Title of the message
 * @param string $message 	Text of the message
 *
 * @return mixed
 */
function flash($title = null, $message = null)
{
	$flash = app('App\Http\Flash');

	if (func_num_args() == 0) {
		return $flash;
	}

	return $flash->info($title, $message);
}

/**
 * Format various objects
 *
 * @param mixed $item 	String or date object
 *
 * @return string    	Formated text
 */
function format($item)
{
	if (is_string($item)) {
			//$item = Carbon::parse($item);
		try {
			$item = Carbon::parse($item);
		} catch (Exception $e) {
			if (strpos($e->getMessage(), 'Failed to parse time string')) {
				$parsed_sql = PMA_SQP_parse(str_replace('`', '', $item));
				return PMA_SQP_formatHtml($parsed_sql);
			}
		}
	}

	if (is_object($item)) {
		switch (get_class($item)) {
			case 'Carbon\Carbon':
				$item->setTimeZone(config('custom.timezone'));
				return $item->format(config('custom.date_format')) . ' ' . $item->format(config('custom.time_format'));
				break;
		}
	}
}

function isTableOrCode($name)
{
	if (Schema::hasTable($name)) {
		return 'table';
	}

	if (isset(code($name)->id)) {
		return 'code';
	}

	return null;
}

/**
 * Detemines the value from either the old() value or the model property value
 *
 * @param string $name    	Variable name
 * @param object $model   	Instance of a model
 * @param mixed $default 	Default value
 *
 * @return mixed
 */
function oldModelValue($name, $model, $default = null)
{
	return old($name, isset($model) && isset($model->{$name}) ? $model->{$name} : $default);
}

/**
 * Add quotes around a string
 *
 * @param string $string
 * @param bool $double        		Use a double instance of the textQualifier when true
 * @param string $textQualifier 	Character to surrond the string
 *
 * @return string
 */
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

/**
 * Return the class for a menu item
 *
 * @param string $id    	Code of the menu item
 * @param int $level 		The level of the menu item
 *
 * @return string    		Menu item class
 */
function setActive($id, $level = 1)
{
	switch ($level) {
		case 1:
			return in_array($id, Request::segments())  ? 'w3-theme-d3' : 'w3-theme w3-hover-theme-l3';
		case 2:
			return in_array($id, Request::segments()) ? 'w3-theme-d1' : 'w3-theme-l2 w3-hover-theme-l4';
		case 3:
			return in_array($id, Request::segments()) ? 'w3-theme' : 'w3-theme-l4 w3-hover-theme-l3';
		default:
			break;
	}
}

/**
 * Place the application in maitenance mode if it isn't already
 *
 * @param mixed $error Either a string or an Exception
 *
 * @return redirect
 */
function shutDown($error)
{
	if (app()->isDownForMaintenance()) {
		throw new HttpException(503);
	} else {
		Artisan::call('down');
		if (is_string($error)) {
			Log::emergency('Automatically putting the application into maintenance mode', [
				'message' => $error,
			]);
		} else {
			Log::emergency('Automatically putting the application into maintenance mode', [
				'message' => $error->getMessage(),
				'code' => $error->getCode(),
				'file' => $error->getFile(),
				'line' => $error->getLine()
			]);
		}

		return redirect('/');
	}
}

/**
 * Returns an instance of Code or a specific Code
 *
 * @param int $id 	User id
 *
 * @return App\Models\User
 */
function user($id = null)
{
	$user = app('App\Models\User');

	if (func_num_args() == 0) {
		return $user;
	}

	return $user->find($id);
}

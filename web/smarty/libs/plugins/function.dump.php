<?php
/**
 * Smarty plugin
 *
 * @package    Smarty
 * @subpackage PluginsFunction
 */

/**
 * Smarty {dump} plugin
 * Type:     function<br>
 * Name:     dump<br>
 * Purpose:  display formatted information for a variable
 *
 * @author Mark Kneisler <mckneisler at hotmail dot com>
 *
 * @param string
 *
 */
function smarty_function_dump($var)
{
	$dirs = split('/', substr(dirname(__FILE__), strlen($_SERVER['DOCUMENT_ROOT'])));
$appDir = '';
if (count($dirs) > 2) {
	for ($i=1; $i<count($dirs)-1; ++$i) {
		$appDir .= $dirs[$i] . '/';
	}
} else {
	$appDir .= '/';
}

	$dump = nl2br(str_replace(' ', '&nbsp;', print_r($dirs, true))) . '<hr>';
	$dump = nl2br(str_replace(' ', '&nbsp;', print_r($appDir, true))) . '<hr>';
	$dump .= nl2br(str_replace(' ', '&nbsp;', print_r($_SERVER, true))) . '<hr>';
	return $dump;
}

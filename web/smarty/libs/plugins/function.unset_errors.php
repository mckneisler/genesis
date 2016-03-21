<?php
/**
 * Smarty plugin
 *
 * @package    Smarty
 * @subpackage PluginsFunction
 */

/**
 * Smarty {unset_errors} function plugin
 * Type:     function<br>
 * Name:     unset_errors<br>
 * Date:     February 11, 2016
 * Purpose:  uset the session error variables.<br>
 * Params:	 none
 * Examples:
 * <pre>
 * {unset_errors}
 * </pre>
 *
 * @link     none
 * @version  1.0
 * @author   Mark Kneisler <mckneisler at hotmail dot com>
 *
 * @return none
 */
function smarty_function_unset_errors($params) {
	unsetErrors();
	return;
}

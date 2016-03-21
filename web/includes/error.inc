<?php
/**
 * Sets a general error
 *
 * @params string $error
 */
function setGeneralError($error) {
	$_SESSION['errors']['generalError'][] = $error;
}

/**
 * Unsets the arrays $_SESSION['errors'] and $_SESSION['return']
 *
 */
function unsetErrors() {
    if (isset($_SESSION['errors'])) {
        unset($_SESSION['errors']);
    }
    if (isset($_SESSION['return'])) {
        unset($_SESSION['return']);
    }
}

function errorHandler($errno, $errstr, $errfile, $errline) {
	$errortype = array (
		E_ERROR => 'ERROR',
		E_WARNING => 'WARNING',
		E_PARSE => 'PARSING ERROR',
		E_NOTICE => 'NOTICE',
		E_CORE_ERROR => 'CORE ERROR',
		E_CORE_WARNING => 'CORE WARNING',
		E_COMPILE_ERROR => 'COMPILE ERROR',
		E_COMPILE_WARNING => 'COMPILE WARNING',
		E_USER_ERROR => 'USER ERROR',
		E_USER_WARNING => 'USER WARNING',
		E_USER_NOTICE => 'USER NOTICE',
		E_STRICT => 'RUNTIME NOTICE',
		E_RECOVERABLE_ERROR => 'CATCHABLE FATAL ERROR'
	);

	$errorMSG  = "PHP ".$errortype[$errno].": $errstr in $errfile on line $errline";

	fatalError($errorMSG);
}

/**
 * When called this function displays the error message on the screen and then
 * exits the script
 */
function fatalError($errorMSG)
{
	global $smarty;

	$callStack = debug_backtrace();
	$errorMSG .= "\n\n";
	while (list($index, $call) = each($callStack)) {
		if ($index > 0) {
			if (!empty($callStack[$index-1]['line']) and !empty($callStack[$index-1]['file'])) {
				if ($call['function'] == "include" or empty($call['function'])) {
					$errorMSG .= "\n";
				} else {
					$errorMSG .= ", within the function '".$call['function']."'\n";
				}
			}
		}
		if (!empty($call['line']) and !empty($call['file'])) {
			$errorMSG .= "On line ".$call['line'];
			$errorMSG .= " in file ".$call['file'];
		}
	}

	$errorMSG .= "\n\nTroubleshooting information:";
	$errorMSG .= "\nIP Address: " . $_SERVER['REMOTE_ADDR'];

	myLog($errorMSG);
  if (defined('DEV_IP') && DEV_IP == $_SERVER['REMOTE_ADDR']) {
    $errorMSG = nl2br($errorMSG);
  } else {
    notifyWebAdmin($errorMSG);
    $errorMSG = "Admin has been notified.";
  }
	$smarty->assign('errorMSG', $errorMSG);
	$smarty->display('fatalerror.tpl');
	exit;
}

?>

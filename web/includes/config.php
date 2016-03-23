<?php
/**
 * setEnv.php
 * December 2, 2005
 *
 * This script sets up smarty and other
 * global settings for the GMS public scripts.
 */
session_start();

//===========================================================
// General Config
//

// Determine the app root
$dirs = split('/', substr(dirname(__FILE__), strlen($_SERVER['DOCUMENT_ROOT'])));
$appDir = '';
if (count($dirs) > 2) {
	for ($i=1; $i<count($dirs)-1; ++$i) {
		$appDir .= $dirs[$i] . '/';
	}
} else {
	$appDir .= '/';
}

$appRoot = $_SERVER['DOCUMENT_ROOT'] . '/' . $appDir;
$incPath = $appRoot . 'includes/';
//error_log('$incPath = "' . $incPath . '"');
$urlRoot = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $appDir;
$imgPath = $urlRoot . 'images/';

//===========================================================
// Smarty Config
//
//define('SMARTY_SPL_AUTOLOAD',1);
require_once($appRoot . 'smarty/libs/Smarty.class.php');
$smarty = new Smarty;
$smarty->template_dir = $appRoot . 'templates';
$smarty->compile_dir = $appRoot . 'smarty/compile';
$smarty->cache_dir = $appRoot . 'smarty/cache';
// Change comment on these when finished developing to improve performance
$smarty->force_compile = true;

require_once('customConfig.php');

$connlink = mysql_connect(DB_HOST,DB_USER,DB_PASS)
	or die('1 CONNECT ERR');

$dbselect = mysql_select_db(DB_NAME,$connlink)
	or die('2 DB ERR:' . DB_NAME);

//===========================================================
// Error log definition
//
define('ERROR_FILE', $appRoot . 'logs/error.log');

//unset($_SESSION['language']);
if (!$_SESSION['language']['name']) {
	$_SESSION['language']['name'] = "";
	$_SESSION['language']['date'] = strtotime("01/01/1900");
}

//===========================================================
// General Initialization
//

set_include_path($incPath);
spl_autoload_register(function ($class) {
	$path = explode(":", ini_get('include_path'));
	$parts = explode('\\', $class);
	if (file_exists ($path[0] . 'class.' . end($parts) . '.php')) {
		require_once $incPath . 'class.' . end($parts) . '.php';
	}
});

require_once $incPath . 'functions.inc';
require_once $incPath . 'language-english.php';
require_once $incPath . 'language-' . $custom['language'] . '.php';
/*
$languageFileDate = filemtime($incPath . 'language-' . $custom['language'] . '.php');
if ($_SESSION['language']['name'] == $custom['language'] && $_SESSION['language']['date'] == $languageFileDate) {
	$language = $_SESSION['language'];
} else {
	require_once $incPath . 'language-english.php';
	require_once $incPath . 'language-' . $custom['language'] . '.php';
	$_SESSION['language'] = $language;
	$_SESSION['language']['name'] = $custom['language'];
	$_SESSION['language']['date'] = $languageFileDate;
}
*/

set_error_handler("\\genesis\\error::errorHandler", ini_get('error_reporting'));

//===========================================================
// Customization
//
$class['swipe'] = "w3-center w3-tiny w3-theme-d3 w3-hide";
$class['tableDiv'] = "w3-responsive";
$class['tableHeader'] = "w3-theme-l3";
$class['header'] = "w3-container w3-theme-l3";
$class['input'] = "w3-input";
$class['button'] = "w3-btn w3-right w3-theme-dark";
$class['form'] = "w3-half";
if ($custom['round']) {
	$class['swipe'] .= " w3-round-large";
	$class['tableDiv'] .= " w3-round-large";
	$class['header'] .= " w3-round-medium";
	$class['input'] .= " w3-round-medium";
	$class['button'] .= " w3-round-xxlarge";
	$class['form'] .= " w3-round-large";
}
switch ($custom['shadow']) {
	case 'none':
		$class['tableDiv'] .= " w3-card";
		$class['form'] .= " w3-card";
		break;
	case 'small':
		$class['tableDiv'] .= " w3-card-4";
		$class['form'] .= " w3-card-4";
		break;
	case 'large':
		$class['tableDiv'] .= " w3-card-8";
		$class['form'] .= " w3-card-8";
		break;
	default:
		break;
}

if (isset($_SESSION['userInfo'])) {
	$smarty->assign('userInfo', $_SESSION['userInfo']);
}
$smarty->assign('menu', $language['menu']);
$smarty->assign('heading', $language['heading']);
$smarty->assign('label', $language['label']);
$smarty->assign('button', $language['button']);
$smarty->assign('message', $language['message']);
$smarty->assign('phrase', $language['phrase']);

$smarty->assign('urlRoot', $urlRoot);
$smarty->assign('imgPath', $imgPath);

$smarty->assign('subnavclass', '');
$smarty->assign('onload', '');
$smarty->assign('onkeypress', '');
$smarty->assign('disabled', '');
$smarty->assign('isSetHeader', false);
$smarty->assign('custom', $custom);
$smarty->assign('class', $class);

?>

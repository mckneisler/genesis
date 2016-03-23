<?php
$menuSelected = "register";
$submenuSelected = "";
require_once(dirname(__FILE__) . '/includes/config.php');

unset($_SESSION['userInfo']);

$oError = new genesis\error;

if (isset($_POST["register"])) {
	$isError = false;
	$setFocusId = "";

	if (strlen(trim($_POST['emailTxt']))) {
		$_SESSION['return']['emailTxt'] = (strlen(trim($_POST['emailTxt'])) > 0) ? trim($_POST['emailTxt']): '';
		if(filter_var($_SESSION['return']['emailTxt'], FILTER_VALIDATE_EMAIL) === false) {
			$_SESSION['errors']['emailTxt'] = 'Invalid email format';
			$isError = true;
		} else {
			$sql  = "SELECT userId ";
			$sql .= "  FROM users usr ";
			$sql .= " WHERE emailTxt = '" . $_SESSION['return']['emailTxt'] . "'";
			$result = myQuery($sql);
			if (mysql_num_rows($result)) {
				$_SESSION['errors']['emailTxt'] = $language['message']['emailAE'];
				$isError = true;
			}
		}
	} else {
		$_SESSION['errors']['emailTxt'] = $language['message']['requiredField'];
		$isError = true;
	}
	if ($_SESSION['errors']['emailTxt'] && !$setFocusId) {
		$setFocusId = "emailTxt";
	}

	if (strlen(trim($_POST['passwordTxt']))) {
		$_SESSION['return']['passwordTxt'] = (strlen(trim($_POST['passwordTxt'])) > 0) ? trim($_POST['passwordTxt']): '';
		$pwErr = '';
		if (strlen($_SESSION['return']['passwordTxt']) < 8) {
			if ($pwErr) {
				$pwErr .= ',';
			}
			$pwErr .= $language['phrase']['greaterThan8Char'];
		}
		if (strlen($_SESSION['return']['passwordTxt']) > 20) {
			if ($pwErr) {
				$pwErr .= ',';
			}
			$pwErr .= $language['phrase']['lessThan20Char'];
		}
		if (!preg_match("/[0-9]/", $_SESSION['return']['passwordTxt'])) {
			if ($pwErr) {
				$pwErr .= ',';
			}
			$pwErr .= $language['phrase']['atLeast1Num'];
		}
		if (!preg_match("/[A-Z]/", $_SESSION['return']['passwordTxt'])) {
			if ($pwErr) {
				$pwErr .= ',';
			}
			$pwErr .= $language['phrase']['atLeast1Upper'];
		}
		if (!preg_match("/[a-z]/", $_SESSION['return']['passwordTxt'])) {
			if ($pwErr) {
				$pwErr .= ',';
			}
			$pwErr .= $language['phrase']['atLeast1Lower'];
		}
		if (!preg_match("/[!@#$%^&*-_]/", $_SESSION['return']['passwordTxt'])) {
			if ($pwErr) {
				$pwErr .= ',';
			}
			$pwErr .= $language['phrase']['atLeast1Spec'];
		}
		if ($pwErr) {
			$pos = strrpos($pwErr, ', ');
			if($pos !== false) {
				$pwErr = substr_replace($pwErr, ' and ', $pos, 2);
			}
			$_SESSION['errors']['passwordTxt'] = $language['message']['invalidPassword'] . $pwErr;
			$isError = true;
		}
	} else {
		$_SESSION['errors']['passwordTxt'] = $language['message']['requiredField'];
		$isError = true;
	}
	if ($_SESSION['errors']['passwordTxt'] && !$setFocusId) {
		$setFocusId = "passwordTxt";
	}

	if (strlen(trim($_POST['passwordTxt2']))) {
		$_SESSION['return']['passwordTxt2'] = (strlen(trim($_POST['passwordTxt2'])) > 0) ? trim($_POST['passwordTxt2']): '';
		if ($_SESSION['return']['passwordTxt'] && $_SESSION['return']['passwordTxt'] != $_SESSION['return']['passwordTxt2']) {
			$_SESSION['errors']['passwordTxt2'] = $language['message']['doesNotMatch'];
			$isError = true;
		}
	} else {
		$_SESSION['errors']['passwordTxt2'] = $language['message']['requiredField'];
		$isError = true;
	}
	if ($_SESSION['errors']['passwordTxt2'] && !$setFocusId) {
		$setFocusId = "passwordTxt2";
	}

	if ($isError) {
		$oError->setGeneralError($language['message']['errorsFound']);
 	} else {
		$new['emailTxt'] = mysql_real_escape_string($_POST['emailTxt']);
		$new['passwordTxt'] = md5(mysql_real_escape_string($_POST['passwordTxt']));

		$newId = myInsert('users', $new);
	}
} else {
	unset($_SESSION['return']);
	$setFocusId = "emailTxt";
}

$smarty->assign('errors',$_SESSION['errors']);
$smarty->assign('return',$_SESSION['return']);
$smarty->assign('menuSelected', $menuSelected);
$smarty->assign('submenuSelected', $submenuSelected);
$smarty->assign('setFocusId', $setFocusId);
$smarty->display('register.tpl');
?>

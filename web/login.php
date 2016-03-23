<?php
$menuSelected = "login";
$submenuSelected = "";
require_once(dirname(__FILE__) . '/includes/config.php');

unset($_SESSION['userInfo']);

$oError = new genesis\error;

if (isset($_POST["login"])) {
  // unset old errors
  $oError->unsetErrors();
  $isError = false;
	$setFocusId = "";

  if (strlen(trim($_POST['emailTxt']))) {
    $_SESSION['return']['emailTxt'] = (strlen(trim($_POST['emailTxt'])) > 0) ? trim($_POST['emailTxt']): '';
    $sql  = "SELECT userId ";
    $sql .= "  FROM users usr ";
    $sql .= " WHERE emailTxt = '" . $_SESSION['return']['emailTxt'] . "'";
		$oDB = new genesis\db;
    $result = $oDB->query($sql);
    if (!mysql_num_rows($result)) {
      $_SESSION['errors']['emailTxt'] = $language['message']['emailNotReg'];
      $isError = true;
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
  } else {
    $_SESSION['errors']['passwordTxt'] = $language['message']['requiredField'];
    $isError = true;
  }
  if ($_SESSION['errors']['passwordTxt'] && !$setFocusId) {
    $setFocusId = "passwordTxt";
  }

  if ($isError) {
    $oError->setGeneralError($language['message']['errorsFound']);
  } else {
    $emailTxt = $_SESSION['return']['emailTxt'];
    $passwordTxt = $_SESSION['return']['passwordTxt'];

    $loginSuccess = processLogin($emailTxt, $passwordTxt);

    if($loginSuccess) {
      redirect($urlRoot . 'artists.php');
    } else {
      $oError->setGeneralError($language['message']['errorsFound']);
      $_SESSION['errors']['passwordTxt'] = $language['message']['incorrectPassword'];
      $setFocusId = "passwordTxt";
    }
  }
} else {
  unset($_SESSION['errors']);
  unset($_SESSION['return']);
  $setFocusId = "emailTxt";
}

$smarty->assign('errors',$_SESSION['errors']);
$smarty->assign('return',$_SESSION['return']);
$smarty->assign('menuSelected', $menuSelected);
$smarty->assign('submenuSelected', $submenuSelected);
$smarty->assign('setFocusId', $setFocusId);
$smarty->display('login.tpl');
?>

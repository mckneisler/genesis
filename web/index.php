<?php
require_once(dirname(__FILE__) . '/includes/config.php');

if (isset($_GET['logout'])) {
    session_destroy();
    redirect($urlRoot . 'artists.php');
}

if (isset($_SESSION['userInfo'])) {
    redirect($urlRoot . 'artists.php');
} else {
    $smarty->assign('menuSelected', 'home');
    $smarty->display('home.tpl');
}

?>

<?php
require_once(dirname(__FILE__) . '/includes/config.php');

if (!isset($_GET['isFav'])) {
    echo "<h3>isFav has not been set</h3>";
    exit;
}
if (!isset($_GET['userId'])) {
    echo "<h3>userId has not been set</h3>";
    exit;
}
if (!isset($_GET['songId'])) {
    echo "<h3>songId has not been set</h3>";
    exit;
}

$error = "";

if ($_GET['isFav'] == 'true') {
    $new['userId'] = mysql_real_escape_string($_GET['userId']);
    $new['songId'] = mysql_real_escape_string($_GET['songId']);

    $newId = myInsert('userFavSongs', $new);
    if (!$newId) {
        $error = mysql_error();
    }
} else {
    $sql  = "DELETE ";
    $sql .= "  FROM userFavSongs ";
    $sql .= " WHERE userId = ". $_GET['userId'] . " ";
    $sql .= "   AND songId = ". $_GET['songId'] . " ";
    $result = myQuery($sql);
    if (!$result) {
        $error = mysql_error();
    }
}

$smarty->assign('error', $error);
$smarty->assign('isFav', $_GET['isFav']);
$smarty->assign('songId', $_GET['songId']);
$smarty->display('ajaxSongFav.tpl');
?>

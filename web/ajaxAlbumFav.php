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
if (!isset($_GET['albumId'])) {
    echo "<h3>albumId has not been set</h3>";
    exit;
}

$error = "";

if ($_GET['isFav'] == 'true') {
    $new['userId'] = mysql_real_escape_string($_GET['userId']);
    $new['albumId'] = mysql_real_escape_string($_GET['albumId']);

    $newId = myInsert('userFavAlbums', $new);
    if (!$newId) {
        $error = mysql_error();
    }
} else {
    $sql  = "DELETE ";
    $sql .= "  FROM userFavAlbums ";
    $sql .= " WHERE userId = ". $_GET['userId'] . " ";
    $sql .= "   AND albumId = ". $_GET['albumId'] . " ";
    $result = myQuery($sql);
    if (!$result) {
        $error = mysql_error();
    }
}

$smarty->assign('error', $error);
$smarty->assign('isFav', $_GET['isFav']);
$smarty->assign('albumId', $_GET['albumId']);
$smarty->display('ajaxAlbumFav.tpl');
?>

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
if (!isset($_GET['artistId'])) {
    echo "<h3>artistId has not been set</h3>";
    exit;
}

$error = "";

//dv($_GET);
if ($_GET['isFav'] == 'true') {
    $new['userId'] = mysql_real_escape_string($_GET['userId']);
    $new['artistId'] = mysql_real_escape_string($_GET['artistId']);

    $newId = myInsert('userFavArtists', $new);
    if (!$newId) {
        $error = mysql_error();
    }
} else {
    $sql  = "DELETE ";
    $sql .= "  FROM userFavArtists ";
    $sql .= " WHERE userId = ". $_GET['userId'] . " ";
    $sql .= "   AND artistId = ". $_GET['artistId'] . " ";
    $result = myQuery($sql);
    if (!$result) {
        $error = mysql_error();
    }
}

$smarty->assign('error', $error);
$smarty->assign('isFav', $_GET['isFav']);
$smarty->assign('artistId', $_GET['artistId']);
$smarty->display('ajaxArtistFav.tpl');
?>

<?php
$menuSelected = "music";
$submenuSelected = "albums";
require_once(dirname(__FILE__) . '/includes/config.php');
//require_once(dirname(__FILE__) . '/includes/authUsersOnly.php');

$sql  = "SELECT DISTINCT ar.artistId, ar.nameTxt AS artistNameTxt ";
$sql .= "  FROM artists ar ";
$sql .= "  LEFT JOIN albums al ";
$sql .= "         ON al.artistId = ar.artistId ";
$sql .= " WHERE 1 = 1 ";
$sql .= " ORDER BY ar.nameTxt ";
$result = myQuery($sql);
$artists[0] = "<All Artists>";
while (List($artistId, $artistNameTxt) = mysql_fetch_row($result)) {
    $artists[$artistId] = $artistNameTxt;
}
if ($_GET['artistId']) {
    $artistId = $_GET['artistId'];
} else {
    $artistId = 0;
}

$sql  = "SELECT ar.artistId, ar.nameTxt AS artistNameTxt, ";
$sql .= "       al.albumId, al.nameTxt AS albumNameTxt ";
if ($_SESSION['isLoggedIn']) {
	$sql .= "     , IF (ufa.userId IS NULL, FALSE, TRUE) AS isFav ";
}
$sql .= "  FROM artists ar ";
$sql .= "  LEFT JOIN albums al ";
$sql .= "         ON al.artistId = ar.artistId ";
if ($_SESSION['isLoggedIn']) {
	$sql .= "  LEFT JOIN (SELECT albumId, userId ";
	$sql .= "               FROM userFavAlbums ";
	$sql .= "              WHERE userId = " . $_SESSION['userInfo']['userId'] . ") ufa  ";
	$sql .= "         ON al.albumId = ufa.albumId ";
}
$sql .= " WHERE 1 = 1 ";
if ($_GET['artistId']) {
    $sql .= "  AND al.artistId = " . $_GET['artistId'];
}
if (strlen($_SESSION['search'])) {
    $sql .= "  AND LOWER(al.nameTxt) LIKE '%" . strtolower($_SESSION['search']) . "%' ";
}
if ($_SESSION['favsOnly']) {
    $sql .= "  AND ufa.userId IS NOT NULL ";
}
$sql .= " ORDER BY ar.nameTxt, al.nameTxt ";
$result = myQuery($sql);
while ($album = mysql_fetch_assoc($result)) {
	$albums[] = $album;
}

$smarty->assign('artistId', $artistId);
$smarty->assign('artists', $artists);
$smarty->assign('albums', $albums);
$smarty->assign('userId', $_SESSION['userInfo']['userId']);
$smarty->assign('isLoggedIn', $_SESSION['isLoggedIn']);

$smarty->assign('menuSelected', $menuSelected);
$smarty->assign('submenuSelected', $submenuSelected);
$smarty->display('albums.tpl');
?>

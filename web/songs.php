<?php
$menuSelected = "music";
$submenuSelected = "songs";
require_once(dirname(__FILE__) . '/includes/config.php');
//require_once(dirname(__FILE__) . '/includes/authUsersOnly.php');

$sql  = "SELECT DISTINCT ar.artistId, ar.nameTxt AS artistNameTxt ";
$sql .= "  FROM artists ar ";
$sql .= "  LEFT JOIN albums al ";
$sql .= "         ON al.artistId = ar.artistId ";
$sql .= " WHERE 1 = 1 ";
if ($_GET['albumId']) {
    $sql .= "  AND al.albumId = " . $_GET['albumId'];
}
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

$sql  = "SELECT al.albumId, al.nameTxt AS albumNameTxt ";
$sql .= "  FROM albums al ";
$sql .= " WHERE 1 = 1 ";
if ($_GET['artistId']) {
    $sql .= "  AND al.artistId = " . $_GET['artistId'];
}
$sql .= " ORDER BY al.nameTxt ";
$result = myQuery($sql);
$albums[0] = "<All Albums>";
while (list($albumId, $albumNameTxt) = mysql_fetch_row($result)) {
    $albums[$albumId] = $albumNameTxt;
}
if ($_GET['albumId']) {
    $albumId = $_GET['albumId'];
} else {
    $albumId = 0;
}

$sql  = "SELECT ar.artistId, ar.nameTxt AS artistNameTxt, ";
$sql .= "       al.albumId, al.nameTxt AS albumNameTxt, ";
$sql .= "       so.songId, so.nameTxt AS songNameTxt ";
if ($_SESSION['isLoggedIn']) {
	$sql .= "     , IF (ufa.userId IS NULL, FALSE, TRUE) AS isFav ";
}
$sql .= "  FROM artists ar ";
$sql .= "  LEFT JOIN albums al ";
$sql .= "         ON al.artistId = ar.artistId ";
$sql .= "  LEFT JOIN songs so ";
$sql .= "         ON so.albumId = al.albumId ";
if ($_SESSION['isLoggedIn']) {
	$sql .= "  LEFT JOIN (SELECT songId, userId ";
	$sql .= "               FROM userFavSongs ";
	$sql .= "              WHERE userId = " . $_SESSION['userInfo']['userId'] . ") ufa  ";
	$sql .= "         ON so.songId = ufa.songId ";
}
$sql .= " WHERE 1 = 1 ";
if ($_GET['artistId']) {
	$sql .= "  AND al.artistId = " . $_GET['artistId'];
}
if ($_GET['albumId']) {
	$sql .= "  AND al.albumId = " . $_GET['albumId'];
}
if (strlen($_SESSION['search'])) {
	$sql .= "  AND LOWER(so.nameTxt) LIKE '%" . strtolower($_SESSION['search']) . "%' ";
}
if ($_SESSION['favsOnly']) {
	$sql .= "  AND ufa.userId IS NOT NULL ";
}
$sql .= " ORDER BY ar.nameTxt, al.nameTxt, so.nameTxt ";
$result = myQuery($sql);
while ($song = mysql_fetch_assoc($result)) {
	$songs[] = $song;
}

$smarty->assign('artistId', $artistId);
$smarty->assign('artists', $artists);
$smarty->assign('albumId', $albumId);
$smarty->assign('albums', $albums);
$smarty->assign('songs', $songs);
$smarty->assign('userId', $_SESSION['userInfo']['userId']);
$smarty->assign('isLoggedIn', $_SESSION['isLoggedIn']);

$smarty->assign('menuSelected', $menuSelected);
$smarty->assign('submenuSelected', $submenuSelected);
$smarty->display('songs.tpl');
?>

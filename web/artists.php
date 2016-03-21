<?php
$menuSelected = "music";
$submenuSelected = "artists";
require_once(dirname(__FILE__) . '/includes/config.php');
//require_once(dirname(__FILE__) . '/includes/authUsersOnly.php');

$sql  = "SELECT ar.artistId, ar.nameTxt ";
if ($_SESSION['isLoggedIn']) {
	$sql .= "     , IF (ufa.userId IS NULL, FALSE, TRUE) AS isFav ";
}
$sql .= "  FROM artists ar ";
if ($_SESSION['isLoggedIn']) {
	$sql .= "  LEFT JOIN (SELECT artistId, userId ";
	$sql .= "               FROM userFavArtists ";
	$sql .= "              WHERE userId = " . $_SESSION['userInfo']['userId'] . ") ufa  ";
	$sql .= "         ON ar.artistId = ufa.artistId ";
}
$sql .= " WHERE 1 = 1 ";
if (strlen($_SESSION['search'])) {
    $sql .= "  AND LOWER(ar.nameTxt) LIKE '%" . strtolower($_SESSION['search']) . "%' ";
}
if ($_SESSION['favsOnly']) {
    $sql .= "  AND ufa.userId IS NOT NULL ";
}
$sql .= " ORDER BY ar.nameTxt ";
$result = myQuery($sql);
while ($artist = mysql_fetch_assoc($result)) {
	$artists[] = $artist;
}
$smarty->assign('artists', $artists);
$smarty->assign('userId', $_SESSION['userInfo']['userId']);
$smarty->assign('isLoggedIn', $_SESSION['isLoggedIn']);

$smarty->assign('menuSelected', $menuSelected);
$smarty->assign('submenuSelected', $submenuSelected);
$smarty->display('artists.tpl');

$smarty->assign('server', $_SERVER);
?>

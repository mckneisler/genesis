<?php
require_once(dirname(__FILE__) . '/includes/config.php');

$songs = file($incPath . "Music.csv");
$i = 0;
echo "<table>";
    echo "<tr>";
        echo "<th>Artist</th>";
        echo "<th>Album</th>";
        echo "<th>Song</th>";
        echo "<th>Status</th>";
    echo "</tr>";
foreach ($songs as $song) {
//    $fields = explode(",", $song);
    $fields = str_getcsv($song, ',');
//dv($fields);
//    if ($fields[1] && $fields[1] == "The Beatles" && !in_array($fields[5], array("Comedy", "Voice Memo"))) {
    if ($fields[1] && $fields[3] && $fields[0] && !in_array($fields[5], array("Comedy", "Voice Memo"))) {
//        if ($i < 20) {
            $artistCreated = false;
            $albumCreated = false;
            $songCreated = false;
            $sql  = "SELECT artistId ";
            $sql .= "  FROM artists ";
            $sql .= " WHERE nameTxt = '" . mysql_real_escape_string($fields[1]) . "'";
            $result = myQuery($sql);
            echo $mysqli->connect_error;
            list($artistId) = mysql_fetch_array($result);
            if (!isset($artistId)) {
                $new['nameTxt'] = $fields[1];
                $artistId = myInsert('artists', $new);
                unset($new);
                $artistCreated = true;
            }
            $sql  = "SELECT albumId ";
            $sql .= "  FROM albums ";
            $sql .= " WHERE nameTxt = '" . mysql_real_escape_string($fields[3]) . "'";
            $sql .= "   AND artistId = " . $artistId;
            $result = myQuery($sql);
            echo $mysqli->connect_error;
            list($albumId) = mysql_fetch_array($result);
            if (!isset($albumId)) {
                $new['artistId'] = $artistId;
                $new['nameTxt'] = $fields[3];
                $albumId = myInsert('albums', $new);
                unset($new);
                $albumCreated = true;
            }
            $sql  = "SELECT songId ";
            $sql .= "  FROM songs ";
            $sql .= " WHERE nameTxt = '" . mysql_real_escape_string($fields[0]) . "'";
            $sql .= "   AND albumId = " . $albumId;
            $result = myQuery($sql);
            echo $mysqli->connect_error;
            list($songId) = mysql_fetch_array($result);
            if (!isset($songId)) {
                $new['albumId'] = $albumId;
                $new['nameTxt'] = $fields[0];
                $artistId = myInsert('songs', $new);
                unset($new);
                $songCreated = true;
            }
            $status = "";
            if ($artistCreated) {
                $status .= "artist";
            }
            if ($status) {
                $status .= " ";
            }
            if ($albumCreated) {
                $status .= "album";
            }
            if ($status) {
                $status .= " ";
            }
            if ($songCreated) {
                $status .= "song";
            }
            $i++;
//        }
        echo "<tr>";
            echo "<th>" . $fields[1] . " (". $artistId . ")</th>";
            echo "<th>" . $fields[3] . "</th>";
            echo "<th>" . $fields[0] . "</th>";
            echo "<th>" . $status . "</th>";
        echo "</tr>";
    }
}
echo "</table>";
?>

<?php

include "db.php";
$result = $mysqli->query('SELECT * FROM settings where kkey="path_to_folder"');
$line = mysqli_fetch_array($result);
$path_to_folder=rtrim($line['value'], "/\\") . "/";
$pid = $_GET['photoId'];
$result = $mysqli->query('SELECT * from foto where id='.$pid);
if ($line = mysqli_fetch_array($result)) {
$url =$path_to_folder.'\\'.$line['name'];
header('Content-Disposition: attachment; filename='.$line['name'].'.jpeg');
readfile($url);
}
$mysqli->query('INSERT INTO down_photo VALUES('.$pid.',"'.$line['name'].'") ON DUPLICATE KEY UPDATE photo = "'.$line['name'].'"');
?>
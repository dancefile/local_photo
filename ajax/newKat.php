<?
include ('../db.php');
$mysqli->query('INSERT INTO `url` (`name`, `parent`) VALUES ("'.$_GET['val'].'", "'.$_GET['per'].'");');
echo $mysqli->insert_id;

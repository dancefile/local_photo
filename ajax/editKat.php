<? 
include ('../db.php');
if (isset($_GET['add'])) {
$mysqli->query('INSERT INTO `url` (`name`, `parent`) VALUES ("'.$_GET['name'].'", '.$_GET['add'].');');
} else {
$mysqli->query('UPDATE `url` SET `name` = "'.$_GET['name'].'" WHERE `url`.`id` = '.$_GET['id'].';');
}
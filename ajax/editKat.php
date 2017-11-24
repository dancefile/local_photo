<? 
include ('../db.php');
if (isset($_POST['add'])) {
$mysqli->query('INSERT INTO `url` (`name`, `parent`) VALUES ("'.$_POST['name'].'", '.$_POST['add'].');');
} else {
$mysqli->query('UPDATE `url` SET `name` = "'.$_POST['name'].'" WHERE `url`.`id` = '.$_POST['id'].';');
}
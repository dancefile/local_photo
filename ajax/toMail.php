<? 
include "../db.php";
$mysqli->query('UPDATE `dancefile`.`zakaz` SET `mail` = "'.$_GET['mail'].'" , `mailStatus`=1 WHERE `zakaz`.`id` = '.$_GET['id'].';');

echo $_GET['mail'].'<br>';

?>Загрузка на сервер

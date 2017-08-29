<?	
include ('../db.php');
include('../lang.php');
//echo 'UPDATE `dancefile`.`flash` SET `toId` = "'.substr($_POST['IdUrl'], 3).'",`photografer` = "'.$_POST['photografer'].'" WHERE `flash`.`id` = '.substr($_POST['IdDir'], 3).';';
$rs = $mysqli->query('UPDATE `dancefile`.`flash` SET `toId` = "'.substr($_POST['IdUrl'], 3).'",`photografer` = "'.$_POST['photografer'].'" WHERE `flash`.`id` = '.substr($_POST['IdDir'], 3).';');
//if ($rs = $mysqli->query('INSERT INTO `dancefile`.`fotos` (`url`,`l`) VALUES (1,0),(2,0),(3,0),(4,0);'))


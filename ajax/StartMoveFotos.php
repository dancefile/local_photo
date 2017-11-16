<?	
include ('../db.php');
include('../lang.php');

$flag=false;
if ($rs = $mysqli->query('SELECT `url` FROM `flash` WHERE `id` = '.substr($_POST['IdDir'], 3)))
if ($line = mysqli_fetch_array($rs)) {
	if (is_writable($line['url'])) {
		$handle = fopen($line['url']."\\test.tmp", "a");
		if ($handle!==FALSE) {$flag=TRUE;fclose($handle);unlink($line['url'].'\\test.tmp');}
	}
}

$flag2=false;
if ($rs = $mysqli->query("SELECT `value` FROM `settings` WHERE `kkey` LIKE 'path_to_folder'"))
if ($line = mysqli_fetch_array($rs)) {
	if (is_writable($line['value'])) $flag2=TRUE; 
}


if ($flag && $flag2) $rs = $mysqli->query('UPDATE `dancefile`.`flash` SET `toId` = "'.substr($_POST['IdUrl'], 3).'",`photografer` = "'.$_POST['photografer'].'" WHERE `flash`.`id` = '.substr($_POST['IdDir'], 3).';');


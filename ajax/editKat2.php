<? 
session_start();
include ('../db.php');
switch (substr($_GET['id'],0,3)) {
	case 'cle':
		
		unset($_SESSION['cutkat']);	
	break;	
	case 'cut':
	$_SESSION['cutkat']=substr($_GET['id'],3);	
		
	break;
	case 'pas':
		if (substr($_GET['id'],3)!=$_SESSION['cutkat']) $mysqli->query('UPDATE `url` SET `parent` = "'.substr($_GET['id'],3).'" WHERE `url`.`id` = '.$_SESSION['cutkat'].';');
	unset($_SESSION['cutkat']);	
	break;
	case 'del':
		$del=true;
if ($rs=$mysqli->query('SELECT id FROM `fotos` WHERE `url` = \''.substr($_GET['id'],3).'\' limit 1')) {} else {$del=false;};	;
if ($line = mysqli_fetch_array($rs)) {$del=false;};
if ($rs=$mysqli->query('SELECT id FROM url where parent=\''.substr($_GET['id'],3).'\' limit 1')) {} else {$del=false;};	;
if ($line = mysqli_fetch_array($rs)) {$del=false;};
if ($del) {$mysqli->query('DELETE FROM `dancefile`.`url` WHERE `url`.`id` = '.substr($_GET['id'],3).';');} else {echo 'Ошибка, папка не пуста';}
break;
}

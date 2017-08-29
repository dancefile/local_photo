<? 
include ('../db.php');
if (isset($_POST['ids'])) {
	$to=substr($_POST['to'],3);
	if ($_POST['ids']=='all') {
		session_start();
		$in=implode(",", $_SESSION['name']);
		
	} else {$in=substr(str_replace('.jpg', '', $_POST['ids']),1);}
	
	//echo 'UPDATE `fotos` SET `url`='.$to.' WHERE `id` IN ('.$in.')';exit;
$mysqli->query('UPDATE `fotos` SET `url`='.$to.' WHERE `id` IN ('.$in.')');
unset($_SESSION['name']);
unset($_SESSION['cd']);
unset($_SESSION['a6']);
unset($_SESSION['a5']);
unset($_SESSION['a4']);
unset($_SESSION['comm']);
unset($_SESSION['korprice']);

}
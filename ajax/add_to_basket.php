<? session_start();
include ('../db.php');
if (isset($_POST['basket'])) {
	$addarr=explode(';', $_POST['basket']);
	foreach ($addarr as  $value) {
		if(!$value) continue;
		 $value =substr($value, 0,-4);
		if (!in_array($value, $_SESSION['name'])) {
			$_SESSION['name'][]=$value;
end($_SESSION['name']);
$k=key($_SESSION['name']);
$_SESSION['cd'][$k]=0;
$_SESSION['a6'][$k]=0;
$_SESSION['a5'][$k]=0;
$_SESSION['a4'][$k]=0;
$_SESSION['comm'][$k]='';
$_SESSION['korprice'][$k]=0;
$mysqli->query('INSERT INTO `baskets` (`name`,`ip`,`data`)  Values (\''.$_GET["name"].'\','.substr($_SERVER['REMOTE_ADDR'],strripos($_SERVER['REMOTE_ADDR'],'.')+1).',now());');}
	}
	
if (isset($_POST['delbasket'])) {	
	$delarr=explode(';', $_POST['delbasket']);
	foreach ($delarr as  $value) {
		$value =substr($value, 0,-4);
	if(!$value) continue;
foreach ($_SESSION['name'] as $i => $value1) {
if ($value1==$value) {
unset($_SESSION['name'][$i]);
unset($_SESSION['cd'][$i]);
unset($_SESSION['a6'][$i]);
unset($_SESSION['a5'][$i]);
unset($_SESSION['a4'][$i]);
unset($_SESSION['comm'][$i]);
unset($_SESSION['korprice'][$i]);
//break;
};
};	
			
	}
}	
	//echo $_POST['basket'];
	echo count($_SESSION['name']);
	exit;
}
if (isset($_GET['name'])) {
	$_GET['name']=substr($_GET['name'], 0,-4);
$arr['del']=FALSE;
$arr['name']=$_GET['name'];
if (isset($_SESSION['name']))
foreach ($_SESSION['name'] as $i => $value) {
	
if ($value==$_GET["name"]) {
$arr['del']=true;	
unset($_SESSION['name'][$i]);
unset($_SESSION['cd'][$i]);
unset($_SESSION['a6'][$i]);
unset($_SESSION['a5'][$i]);
unset($_SESSION['a4'][$i]);
unset($_SESSION['comm'][$i]);
unset($_SESSION['korprice'][$i]);
};
};

if (!$arr['del']) {
$_SESSION['name'][]=$_GET['name'];
end($_SESSION['name']);
$k=key($_SESSION['name']);
$_SESSION['cd'][$k]=0;
$_SESSION['a6'][$k]=0;
$_SESSION['a5'][$k]=0;
$_SESSION['a4'][$k]=0;
$_SESSION['comm'][$k]='';
$_SESSION['korprice'][$k]=0;
$mysqli->query('INSERT INTO `baskets` (`name`,`ip`,`data`)  Values (\''.$_GET["name"].'\','.substr($_SERVER['REMOTE_ADDR'],strripos($_SERVER['REMOTE_ADDR'],'.')+1).',now());');
};
echo json_encode($arr);}

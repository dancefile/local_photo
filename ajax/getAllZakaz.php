<?php
session_start();
if(!$_SESSION['auth'])
{
    header("Location: ./admin_auth.php");
    die();
}
?>


<?php
include_once "../db.php";
include "../getDownloadPhoto.php";
$downloadedPhoto = getDownPhoto();
if (isset($_GET['payd'])) {if ($_GET['payd']) {$payd=' and oplata!=0';} else {$payd=' and oplata=0';}; } else $payd='';
if (isset($_GET['ready'])) $ready  =$_GET['ready']; else $ready  ='';
if (isset($_GET['deleted'])) $deleted = $_GET['deleted']; else $deleted = '';
if (isset($_GET['showAll'])) $showAll = $_GET['showAll']; else $showAll='';

$query = "SELECT * from zakaz where del=$deleted $payd and ok = $ready ORDER BY `zakaz`.`id` ";
if($showAll=="true" || !isset($_GET['payd'])){
    $query ="SELECT * from zakaz where del=$deleted ";
}
$arr = array();
$i = 0;
if ($rs = $mysqli->query($query))
while ($line = mysqli_fetch_array($rs)) {
    $A = array();
    foreach( $line as $key=>$val){
        $A[strval($key)] = $val;
    }
	switch ($A['oplata']) {
		case '0':$A['oplata']='NO';	break;
		case '1':$A['oplata']='Сash';break;
		case '2':$A['oplata']='Transfer';break;
		case '3':$A['oplata']='Other';break;
			}
	
	if ($A['ok']) {$A['ok']='Yes';} else {$A['ok']='No';};

    $arr[$i++] = $A;
}

echo json_encode($arr);
?>
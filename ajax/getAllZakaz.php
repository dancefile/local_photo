<?php
session_start();
if(!$_SESSION['auth'])
{
    header("Location: ./admin_auth.php");
    die();
}

include_once "../db.php";
include('../class/multilanguage.php');
$langarray['NO']=array('нет','no');
$langarray['Сash']=array('Наличные','Сash');
$langarray['Transfer']=array('Перевод','Transfer');
$langarray['Other']=array('Прочие','Other');
$langarray['yes']=array('да','yes');
$langarray['no']=array('нет','no');
$newlanguage= new Multilanguage($langarray);


$downloadedPhoto = array();
if ($rs = $mysqli->query('select * from down_photo'))
    while ($line = mysqli_fetch_array($rs))
    {
        $downloadedPhoto[$line['photo_id']]=true;
    }
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
		case '0':$A['oplata']=$newlanguage->NO;	break;
		case '1':$A['oplata']=$newlanguage->Сash;break;
		case '2':$A['oplata']=$newlanguage->Transfer;break;
		case '3':$A['oplata']=$newlanguage->Other;break;
			}
	
	if ($A['ok']) {$A['ok']=$newlanguage->yes;} else {$A['ok']=$newlanguage->NO;};

    $arr[$i++] = $A;
}

echo json_encode($arr);
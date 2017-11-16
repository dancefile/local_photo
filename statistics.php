<? 
session_start();
//$_SESSION['lang']=1;
if(!$_SESSION['auth']) {header("Location: ./admin_auth.php");die();}
include ('db.php');
//include('lang.php');
include('class/multilanguage.php');
$langarray['admin']=array('Админ','Admin');
$langarray['Photographers']=array('Фотографы:','Photographers:');
$langarray['Paid']=array('Оплачено:','Paid:');
$langarray['amount']=array(' Сумма:',' Amount:');
$langarray['Create_a_report_andclear_the_database']=array('Создать отчет и очистить базу данных','Create a report and clear the database');
$langarray['Sales']=array(' Продано:',' Sales:');
$langarray['Made_a_photo']=array(' Сфотографировал ',' Made a photo: ');
$langarray['']=array('','');
$newlanguage= new Multilanguage($langarray);
?>
<!DOCTYPE html>
<html>
<head>
 <meta charset="UTF-8">
 <title>Admin</title>
 <script src="./js/jquery-1.11.1.min.js"></script>
 <script src="./js/admin.js"></script>
 <link rel="stylesheet" type="text/css" href="./css/admin.css"/>
 </head>
<body >
<script type="text/javascript"><!--
var flag= false;
$( document ).ready(function() {
window.onbeforeunload = function (e) { 
  // Ловим событие для Interner Explorer 
 if (flag) {var e = e || window.event; 
  var myMessage= "Вы действительно хотите покинуть страницу, не сохранив данные?"; 
  // Для Internet Explorer и Firefox 
  if (e) { 
    e.returnValue = myMessage; 
  } 
  // Для Safari и Chrome 
  return myMessage; 
}; };
});	
	//--></script>	
	<a href="/admin.php"><?=$newlanguage->admin?></a><br>
<?

include ('db.php');

//статистика
if ($result = $mysqli->query('Select sum(summa) as payedSum from zakaz	where oplata!=0 and del=0'))
while ($line = mysqli_fetch_array($result)) {
echo $newlanguage->Paid. $line['payedSum'].'<br><br>'.$newlanguage->Photographers.'<br>';
};

if ($result = $mysqli->query('Select * from `fotografers`'))
while ($line = mysqli_fetch_array($result)) {

if ($result2 = $mysqli->query('SELECT COUNT(id) FROM `fotos` WHERE photografer='.$line['id']))
while ($line2 = mysqli_fetch_array($result2)) {
echo $line['name'].$newlanguage->Made_a_photo.$line2['COUNT(id)'];
if ($result3 = $mysqli->query('Select COUNT(fotos.id) as cnt, sum(`foto`.`price`) as sum from zakaz, foto,fotos where zakaz.oplata!=0 and zakaz.del=0 and zakaz.id=foto.zakaz and foto.name=fotos.id and fotos.photografer='.$line['id']))
while ($line3 = mysqli_fetch_array($result3)) {	
	echo $newlanguage->Sales .$line3['cnt']. $newlanguage->amount .$line3['sum'];
}	echo '<br>';
}

}
?><br><br><br>
<div id='dreport'><button id='report'><?=$newlanguage->Create_a_report_andclear_the_database?></button></div>
</body>
</html>
<?
exit;
//Очистака архива
if ($result = $mysqli->query('SELECT * FROM `fotos`'))
while ($line = mysqli_fetch_array($result)) {
if (!is_file('C:\arhive\\'.$line['id']))	{echo $line['id'].'<br>';
$mysqli->query('DELETE FROM `fotos` WHERE `id`='.$line['id']);
};}

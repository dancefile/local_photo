<?


set_time_limit(120);
include "db.php";
include('lang.php');

//Очистака архива
if ($result = $mysqli->query('Select sum(summa) as payedSum from zakaz	where oplata!=0 and del=0'))
while ($line = mysqli_fetch_array($result)) {
echo 'Оплачено: '. $line['payedSum'].'<br><br>Фотографы:<br>';
};

if ($result = $mysqli->query('Select * from `fotografers`'))
while ($line = mysqli_fetch_array($result)) {

if ($result2 = $mysqli->query('SELECT COUNT(id) FROM `fotos` WHERE photografer='.$line['id']))
while ($line2 = mysqli_fetch_array($result2)) {
echo $line['name'].' Сфоткал: '.$line2['COUNT(id)'];
if ($result3 = $mysqli->query('Select COUNT(fotos.id) as cnt, sum(`foto`.`price`) as sum from zakaz, foto,fotos where zakaz.oplata!=0 and zakaz.del=0 and zakaz.id=foto.zakaz and foto.name=fotos.id and fotos.photografer='.$line['id']))
while ($line3 = mysqli_fetch_array($result3)) {	
	echo ' продано: '.$line3['cnt'].' сумма: '.$line3['sum'];
}	echo '<br>';
}

}



exit;
//Очистака архива
if ($result = $mysqli->query('SELECT * FROM `fotos`'))
while ($line = mysqli_fetch_array($result)) {
if (!is_file('C:\arhive\\'.$line['id']))	{echo $line['id'].'<br>';
$mysqli->query('DELETE FROM `fotos` WHERE `id`='.$line['id']);
};}

<?
ini_set('max_execution_time', '110');
session_start();
if (!isset($_SESSION['rep'])) {$_SESSION['rep']=0;} 
$_SESSION['rep']++;


switch ($_SESSION['rep']) {
case '1':
	include "../db.php";
$result = $mysqli->query('SELECT * FROM settings where kkey="path_to_folder"');
$line = mysqli_fetch_array($result);
$path_to_folder=rtrim(iconv('UTF-8','cp1251',$line['value']), '\\/').'/';

$allUrl=array();

$rs = $mysqli->query('SELECT id,name,parent FROM url ORDER BY `url`.`id` ASC;');
while ($line = mysqli_fetch_array($rs)) {
$allUrl[$line["id"]]=$line["name"];
$allUrlP[$line["id"]]=$line["parent"];
};
	end($allUrl);
	$fp = fopen($path_to_folder.'url.lib', 'w');
	fwrite($fp, "\r\n"); 
for ($i=1; $i < key($allUrl)+1; $i++) {

	if (isset($allUrl[$i])) $str=$allUrlP[$i].' '.$allUrl[$i]; else $str=''; 
fwrite($fp, $str."\r\n");
};
fclose($fp);	

	$allUrl=array();
 $rs = $mysqli->query('SELECT id,url FROM fotos ORDER BY `id` ASC;');
while ($line = mysqli_fetch_array($rs)) {
$allUrl[$line["id"]]=$line["url"];
};
	end($allUrl);
	$fp = fopen($path_to_folder.'photo.lib', 'w');
	fwrite($fp, "\r\n"); 
for ($i=1; $i < key($allUrl)+1; $i++) { 
	if (isset($allUrl[$i])) $str=$allUrl[$i]; else $str=''; 
fwrite($fp, $str."\r\n");
};
fclose($fp);


echo 'Архив закрыт';		
break;

case '2':
include "../db.php";
include '../report.class.php';
$report = new Report();
$result = $mysqli->query('SELECT * FROM settings where kkey="path_to_folder"');
$line = mysqli_fetch_array($result);
$report->archive_path=rtrim(iconv('UTF-8','cp1251',$line['value']), '\\/').'/';
$report->write(); 
echo 'Отчет сформирован.';		
		break;
		
case '3':
	include "../db.php";	
	include '../report.class.php';
	$report = new Report();
	$report->cleardb_enable = true;             //Включите функцию очистки базы
    $report->cleardb();
echo 'База очищена';	
	break; 
case '4':
	  foreach (glob('../ps/*') as $file) {
	  	unlink($file);
        }
echo 'Кэш превью очищен';		
		break;

case '5':
	  foreach (glob('../pm/*') as $file) {
	  	unlink($file);
        }
echo 'Кэш фото очищен';		
		break;	
	default:
		unset($_SESSION['rep']);
		break;
}





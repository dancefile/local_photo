<?
include "db.php";
$result = $mysqli->query('SELECT * FROM settings where kkey="path_to_folder"');
$line = mysqli_fetch_array($result);
$urlde=iconv('UTF-8','cp1251',rawurldecode($_SERVER['REQUEST_URI']));
$url = explode("/", $urlde);

switch ($url[1]) {
		case 'pb':

if(is_file('C:\Apache24\htdocs\pm\\'.$url[2])) {	
header('Status: 200 Ok');
header('Content-Type: image/jpeg');
readfile('C:\Apache24\htdocs\pm\\'.$url[2]);	
break;	
}	
		
		
	case 'pm':

if(is_file($line['value'].'/'.substr($url[2], 0, strpos($url[2],'.')))) {	
exec('C:\Apache24\htdocs\exe\jpeg_exe4.exe "'.$line['value'].'/'.substr($url[2], 0, strpos($url[2],'.')).'" "C:\Apache24\htdocs\pm\\'.$url[2].'"',$str);
header('Status: 200 Ok');
header('Content-Type: image/jpeg');
readfile('C:\Apache24\htdocs\pm\\'.$url[2]);		
}	
		
		break;
	

	
	default:
		
		break;
}

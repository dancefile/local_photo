<?
include "db.php";
///include('d.php');
//$/url = explode("/", '/ph/15.jpg');
//$com = new COM("DynamicWrapperX.2");
//$com->Register('Project1.dll', 'mydiv2', 'i=wwwwwll', 'r=l');
//echo $com->mydiv2($path_to_folder[0].'/'.$url[2],$_SERVER['DOCUMENT_ROOT'].'/'.$url[1].'/'.$url[2],'',substr($url[2],0,-4),'',180,90);

//exit();
//if ($_SERVER["SERVER_NAME"]!='art1.com' && $_SERVER["SERVER_NAME"]!='192.168.1.2') {header( 'Location: http://192.168.1.2/'); exit;};
//$start = microtime(true);	
//include "db.php";
//include('d.php');
//$com = new COM("DynamicWrapperX.2");
//$com->Register('test.dll', 'start', 'i=l', 'r=l');
//echo $com->start(1);
//exec('1.exe',$str);
//print_r($str);

 //$image = exif_thumbnail('C:\arhive\\'.rand(1, 1000).'.jpg', $width, $height, $type);
 //$image=imagerotate($image, 90);
 // header('Content-type: ' .image_type_to_mime_type($type));
  // echo $image;

//echo $width;

 
//echo $str.$str1;
//include('dd.php');
//$time = microtime(true) - $start;	
//printf('Скрипт выполнялся %.4F сек.<br>', $time);
//exit;
$result = $mysqli->query('SELECT * FROM settings where kkey="path_to_folder"');
$line = mysqli_fetch_array($result);
$urlde=iconv('UTF-8','cp1251',rawurldecode($_SERVER['REQUEST_URI']));
$url = explode("/", $urlde);
//echo $line['value'].'/'.substr($url[2], 0, strpos($url[2],'.'));


//print_r($str);
//echo $url[1];

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
exec('C:\Apache24\htdocs\exe\jpeg_exe4.exe '.$line['value'].'/'.substr($url[2], 0, strpos($url[2],'.')).' C:\Apache24\htdocs\pm\\'.$url[2],$str);
//echo 'C:\Apache24\htdocs\exe\jpeg_exe4.exe '.$line['value'].'/'.substr($url[2], 0, strpos($url[2],'.')).' C:\Apache24\htdocs\pm\\'.$url[2];
//$f =fopen('error.txt',"a");
//fwrite($f, 'C:\Apache24\htdocs\exe\jpeg_exe4.exe '.$line['value'].'/'.substr($url[2], 0, strpos($url[2],'.')).' C:\Apache24\htdocs\pm\\'.$url[2]."\r\n");
//fclose($f);
header('Status: 200 Ok');
header('Content-Type: image/jpeg');
readfile('C:\Apache24\htdocs\pm\\'.$url[2]);		
}	
		
		break;
	

	
	default:
		
		break;
}


exit;
//echo $_SERVER['DOCUMENT_ROOT'].'/'.$url[1];exit;
if ($url[1]=='ph') {
if(is_file($path_to_folder[0].'/'.$url[2])) {
if (!is_dir($_SERVER['DOCUMENT_ROOT'].'/'.$url[1])) mkdir($_SERVER['DOCUMENT_ROOT'].'/'.$url[1], 0777, true);
$com = new COM("DynamicWrapperX.2");
$com->Register('Project1.dll', 'mydiv2', 'i=wwwwwll', 'r=l');
$orient=$com->mydiv2($path_to_folder[0].'/'.$url[2],$_SERVER['DOCUMENT_ROOT'].'/'.$url[1].'/'.$url[2],'',substr($url[2],0,-4),'',0,90);
header('Content-Type: image/jpeg');
if(is_file($_SERVER['DOCUMENT_ROOT'].$urlde))
{header('Status: 200 Ok');
readfile($_SERVER['DOCUMENT_ROOT'].$urlde);	
//list($width, $height, $type, $attr) = getimagesize($_SERVER['DOCUMENT_ROOT'].$urlde);
///////////if ($orient==0 || $orient==180) {mysql_query('UPDATE `dancefile`.`fotos` SET `l` = "1" WHERE `fotos`.`id` = '.substr($url[2],0,-4));};
}
else readfile($_SERVER['DOCUMENT_ROOT'].'/images/no_foto.jpg');	
} else {header('Content-Type: image/jpeg');
readfile($_SERVER['DOCUMENT_ROOT'].'/images/no_foto.jpg');
exit;};
};

if ($url[1]=='pb') {if(is_file($path_to_folder[0].'/'.$url[2])) {
if (!is_dir($_SERVER['DOCUMENT_ROOT'].'/'.$url[1])) mkdir($_SERVER['DOCUMENT_ROOT'].'/'.$url[1], 0777, true);
$com = new COM("DynamicWrapperX.2");
$com->Register('Project1.dll', 'mydiv2', 'i=wwwwwll', 'r=l');
$com->mydiv2($path_to_folder[0].'/'.$url[2],$_SERVER['DOCUMENT_ROOT'].'/'.$url[1].'/'.$url[2],'watermarks.png','','',1200,90);
header('Content-Type: image/jpeg');
if(is_file($_SERVER['DOCUMENT_ROOT'].$urlde)) {header('Status: 200 Ok');
readfile($_SERVER['DOCUMENT_ROOT'].$urlde);	
} else readfile($_SERVER['DOCUMENT_ROOT'].'/images/no_foto.jpg');	
} else {header('Content-Type: image/jpeg');
readfile($_SERVER['DOCUMENT_ROOT'].'/images/no_foto.jpg');
exit;};
};
	
if ($url[1]=='pz') {if(is_file($path_to_folder[0].'/'.$url[2])) {
if (!is_dir($_SERVER['DOCUMENT_ROOT'].'/'.$url[1])) mkdir($_SERVER['DOCUMENT_ROOT'].'/'.$url[1], 0777, true);
$com = new COM("DynamicWrapperX.2");
$com->Register('Project1.dll', 'mydiv2', 'i=wwwwwll', 'r=l');
$com->mydiv2($path_to_folder[0].'/'.$url[2],$_SERVER['DOCUMENT_ROOT'].'/'.$url[1].'/'.$url[2],'','','',1800,90);
header('Content-Type: image/jpeg');
if(is_file($_SERVER['DOCUMENT_ROOT'].$urlde)) {header('Status: 200 Ok');
readfile($_SERVER['DOCUMENT_ROOT'].$urlde);	
} else readfile($_SERVER['DOCUMENT_ROOT'].'/images/no_foto.jpg');	
} else {header('Content-Type: image/jpeg');
readfile($_SERVER['DOCUMENT_ROOT'].'/images/no_foto.jpg');
exit;};
};

?>
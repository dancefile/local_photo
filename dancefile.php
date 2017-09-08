<? 
ini_set('upload_max_filesize', '60M');     
ini_set('max_execution_time', '150');
ini_set('memory_limit', '128M');
ini_set('post_max_size', '60M');
$server=9;//5 
include ('db.php');
 $start = microtime(true);
 $action=false;
if ($result = $mysqli->query('SELECT * FROM settings where kkey="iddancefile"'))
if ($line = mysqli_fetch_array($result)) {$iddancefile=$line['value'];}

$result = $mysqli->query('SELECT * FROM settings where kkey="path_to_folder"');
if ($line = mysqli_fetch_array($result)) $path_to_folder=rtrim(iconv('UTF-8','cp1251',$line['value']), '\\/');




if (isset($_GET['lib'])) {

$allUrl=array();
$query = 'SELECT id,name,parent FROM url ORDER BY `url`.`id` ASC;';
$rs = $mysqli->query('SELECT id,name,parent FROM url ORDER BY `url`.`id` ASC;');
while ($line = mysqli_fetch_array($rs)) {
$allUrl[$line["id"]]=$line["name"];
$allUrlP[$line["id"]]=$line["parent"];
};
	end($allUrl);
	$fp = fopen($path_to_folder.'/url.lib', 'w');
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
	$fp = fopen($path_to_folder.'/photo.lib', 'w');
	fwrite($fp, "\r\n"); 
for ($i=1; $i < key($allUrl)+1; $i++) { 
	if (isset($allUrl[$i])) $str=$allUrl[$i]; else $str=''; 
fwrite($fp, $str."\r\n");
};
fclose($fp);
	
if ($iddancefile && is_file($path_to_folder.'/photo.lib') && is_file($path_to_folder.'/url.lib')) {
  $post_var['id_news']=$iddancefile;
  //$post_var['fotofile']= base64_encode(file_get_contents($path_to_folder.'/photo.lib'));		
  //$post_var['fotourl']= base64_encode(file_get_contents($path_to_folder.'/url.lib'));	
  $post = http_build_query($post_var);
  $options = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded
         User-Agent: Mozilla/3.9',
        'content' => $post
     )
    );
  $context = stream_context_create($options);
    $result = file_get_contents('http://www.dancefile.ru/connect_server3.php?renew', false, $context);};
  echo $result; 




}//lib

exit();

//function
function deltree($folder) {
    if (is_dir($folder)) {
        $handle = opendir($folder);
        while ($subfile = readdir($handle)) {
            if ($subfile == '.' or $subfile == '..') continue;
            if (is_file($subfile)) @unlink("{$folder}/{$subfile}");
            else deltree("{$folder}/{$subfile}");
        }
        @closedir($handle);
        if (@rmdir($folder)) return true;
        else return false;
    } else {
        if (@unlink($folder)) return true;
        else return false;
    }
    return false;
}

//end function
 ?>
<script type="text/javascript">
setTimeout(function() { location.reload(); }, 250000)
</SCRIPT>
<html>
<head>
<title>DanceFile</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php
$somepage = file_get_contents('http://www.dancefile.ru/connect_server2.php?new_order&server='.$server);
//echo $somepage; 

$zapros=explode(";", $somepage);
if ($zapros[0]=='order') {
 switch ($zapros[1]) {
  case 'd':
	deltree(iconv("UTF-8","Windows-1251",$zapros[2]));
	echo iconv("UTF-8","Windows-1251",$zapros[2]);
  break;		
  
  case 'f':

  $post_var['id_news']=$zapros[2];
  $post_var['namef']= $zapros[3];
  if (is_file(iconv("UTF-8","Windows-1251",$zapros[4].'/'.substr($zapros[3],0,-4).'.jpg')))  
  $post_var['fotofile']= base64_encode(file_get_contents(iconv("UTF-8","Windows-1251",$zapros[4].'/'.substr($zapros[3],0,-4).'.jpg')));
    if (is_file(iconv("UTF-8","Windows-1251",$zapros[4].'/'.substr($zapros[3],0,-4).'')))  
  $post_var['fotofile']= base64_encode(file_get_contents(iconv("UTF-8","Windows-1251",$zapros[4].'/'.substr($zapros[3],0,-4).'')));		
  $post = http_build_query($post_var);
  $options = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded
         User-Agent: Mozilla/3.9',
        'content' => $post
     )
    );
  $context = stream_context_create($options);
  $result = file_get_contents('http://www.dancefile.ru/connect_server2.php?foto', false, $context);
    echo $result; 
  break; 

   case 'l':
	   if (is_file(iconv("UTF-8","Windows-1251",$zapros[2].'/photo.lib')) && is_file(iconv("UTF-8","Windows-1251",$zapros[2].'/url.lib'))) {
  $post_var['id_news']=$zapros[3];
  $post_var['fotofile']= base64_encode(file_get_contents(iconv("UTF-8","Windows-1251",$zapros[2].'/photo.lib')));		
  $post_var['fotourl']= base64_encode(file_get_contents(iconv("UTF-8","Windows-1251",$zapros[2].'/url.lib')));	
  $post = http_build_query($post_var);
  $options = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded
         User-Agent: Mozilla/3.9',
        'content' => $post
     )
    );
  $context = stream_context_create($options);
  $result = file_get_contents('http://www.dancefile.ru/connect_server2.php?addlib', false, $context);};
  echo $result; 
  break;  
  
  case 't':
	$k=count($zapros)-2;
	$post_var=array();
	for ($i = 1; $i <$k ; $i++) {
	$zapros1=explode("|", iconv("UTF-8","Windows-1251",$zapros[$i+1]));
    $link= $zapros1[0].'/'.$zapros1[1];

	if (is_file($link)) {
	$exif = exif_read_data($link, 0, true);
	if (isset($exif['EXIF']['DateTimeOriginal'])) {$date=$exif['EXIF']['DateTimeOriginal'];} else {$date=date ("Y-m-d H:i:s", filemtime($link));};	

	exec('C:\Apache24\htdocs\exe\jpeg_exe4.exe "'.$link.'" "'.__DIR__.'\tmp\dancefile'.$i.'.jpg"',$str);	
	
	$image = imagecreatefromjpeg(__DIR__.'\tmp\dancefile'.$i.'.jpg');
    $orig_width=imagesx($image);
    $orig_height=imagesy($image);
    $width = $orig_width;
    $height = $orig_height;
    $max_height=600;
    $max_width=600;
    if ($height > $max_height) {
        $width = ($max_height / $height) * $width;
        $height = $max_height;
    }
    if ($width > $max_width) {
        $height = ($max_width / $width) * $height;
        $width = $max_width;
    }
    $image_m = imagecreatetruecolor($width, $height);
    imagecopyresampled($image_m, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);
	if ($width > $height) {$stamp = imagecreatefrompng('dancefile_m_l.png');} else {$stamp = imagecreatefrompng('dancefile_m_p.png');};
    imagecopy($image_m, $stamp,($width-imagesx($stamp))/2, ($height-imagesy($stamp))/2, 0, 0, imagesx($stamp), imagesy($stamp));
	$str=$zapros1[2]."/".$zapros1[1]; 
	$textcolor = imagecolorallocate($image_m, 255, 255, 255);
    imagestring($image_m, 1,0 , 0, $str, $textcolor);
    imagejpeg ($image_m,   __DIR__.'\tmp\dancefile_m.jpg',85);
	imagedestroy($image_m);
	$max_height=150;
    $max_width=150;
    if ($height > $max_height) {
        $width = ($max_height / $height) * $width;
        $height = $max_height;
    }
    if ($width > $max_width) {
        $height = ($max_width / $width) * $height;
        $width = $max_width;
    }
    $image_s = imagecreatetruecolor($width, $height);
    imagecopyresampled($image_s, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);
	$red = imagecolorallocatealpha($image_s, 0, 0, 0, 65);
	imagefilledrectangle($image_s,0,$height-17,$width,$height,$red);
	$textcolor = imagecolorallocate($image_s, 255, 255, 255);
	$left = round($width/2-20);
	imagestring($image_s, 5,$left , $height-17, $zapros1[1], $textcolor);
	imagejpeg ($image_s,   __DIR__.'\tmp\dancefile_s.jpg');
	imagedestroy($image_s);
	if ($orig_width > $orig_height){$stamp = imagecreatefrompng('dancefile_b_l.png');} else {$stamp = imagecreatefrompng('dancefile_b_p.png');};
	imagecopy($image, $stamp,($orig_width-imagesx($stamp))/2, ($orig_height-imagesy($stamp))/2, 0, 0, imagesx($stamp), imagesy($stamp));
	$textcolor = imagecolorallocate($image, 255, 255, 255);
    imagestring($image, 1,0 , 0, $str, $textcolor);
	imagejpeg ($image,   __DIR__.'\tmp\dancefile_b.jpg');
	imagedestroy($image);
	$post_var['id_news'.$i]=$zapros1[2];
    $post_var['name'.$i]= $zapros1[1];  
    $post_var['date'.$i]= $date;      
    $post_var['img_b'.$i]= base64_encode(file_get_contents(__DIR__.'\tmp\dancefile_b.jpg'));
	$post_var['img_s'.$i]= base64_encode(file_get_contents(__DIR__.'\tmp\dancefile_s.jpg'));
	$post_var['img_m'.$i]= base64_encode(file_get_contents(__DIR__.'\tmp\dancefile_m.jpg'));
	} else {	$post_var['id_news'.$i]=$zapros1[2];
    $post_var['name'.$i]= $zapros1[1];
	$post_var['delet'.$i]= 'true'; 
	}};
$post = http_build_query($post_var);
$options = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded
User-Agent: Mozilla/3.9',
  
        'content' => $post
    )
);
$context = stream_context_create($options);
$result = file_get_contents('http://www.dancefile.ru/connect_server2.php?img', false, $context);
$time = microtime(true) - $start;	
printf('Скрипт выполнялся %.4F сек.<br>', $time);
echo $result;

			break;
	

			
}}
		
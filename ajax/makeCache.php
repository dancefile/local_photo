<?
include ('../db.php');

$result = $mysqli->query('SELECT * FROM settings where kkey="path_to_folder"');
$line = mysqli_fetch_array($result);
$urlde=rtrim(iconv('UTF-8','cp1251',$line['value']), '\\/').'/';

$rs = $mysqli->query('SELECT id FROM `fotos` WHERE `data` IS NULL limit 10');
while ($line = mysqli_fetch_array($rs)) {
if(is_file($urlde.$line['id'])) {	

$exif_ifd0 = read_exif_data($urlde.$line['id'],'IFD0' ,0);

if (@array_key_exists('DateTime', $exif_ifd0)) 
{
  $camDate = $exif_ifd0['DateTime'];
 } else { $camDate = date ("Y:m:d H:i:s", filemtime($urlde.$line['id']));}
 //echo $camDate;
 if (!is_file(__DIR__.'\..\pm\\'.$line['id'].'.jpg'))
 	exec('C:\Apache24\htdocs\exe\jpeg_exe4.exe "'.$urlde.$line['id'].'" "'.__DIR__.'\..\pm\\'.$line['id'].'.jpg"',$str);	
 
  if (!is_file(__DIR__.'\..\pm\\'.$line['id'].'.jpg')) {echo 'ererwww';exit;}
  
 	$image = imagecreatefromjpeg(__DIR__.'\..\pm\\'.$line['id'].'.jpg');
	$max_height=200;
    $max_width=200;
    $orig_width=imagesx($image);
    $orig_height=imagesy($image);
    $width = $orig_width;
    $height = $orig_height;
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
	imagefilledrectangle($image_s,0,$height-22,$width,$height,$red);
	$x=10;
$y=$height-1;
//	$left = round($width/2-20);
$white = imagecolorallocate($image_s, 255, 255, 255);

	$font = 'arial.ttf';
$bbox = imageftbbox(20, 0, $font, $line['id']);
$x=round(($width+$bbox[0]-$bbox[2])/2);
imagefttext($image_s, 20, 0, $x, $y, $white, $font, $line['id']);
	imagejpeg ($image_s,   __DIR__.'\..\ps\\'.$line['id'].'.jpg',90);
	imagedestroy($image_s);
	$mysqli->query('UPDATE `fotos` SET `data` = "'.$camDate.'" WHERE `fotos`.`id` = '.$line['id']);
	} else {$mysqli->query('DELETE FROM `fotos` WHERE `id`='.$line['id']);};
echo $line['id'].';';
}  
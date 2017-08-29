<?php
ini_set('max_execution_time', '999');
$zid = $_GET['zid'];
$command = $_GET['command'];
include "db.php";
$result = $mysqli->query('SELECT * FROM settings where kkey="path_to_folder"');
$line = mysqli_fetch_array($result);
$path_to_folder=$line['value'];
if($command=="cd"){
    $query=" and cd=1";
} else {$query='';}

header('Content-Disposition: attachment; filename="'.$zid.'.vlz"');
$file_folder = rtrim($path_to_folder, "/") . "/"; // папка с файлами
$dir=$file_folder.'cd/';
if (is_dir($dir)) {
  if ($dh = opendir($dir)) {
    while (($file = readdir($dh)) !== false) {
if( $file == '.' || $file == '..' || is_dir($dir.$file)) continue;
 echo $file.';'.filesize($dir.$file).';'; 
 readfile($dir.$file);
		}}}


$result =$mysqli->query('SELECT * FROM `foto` where `zakaz`='.$zid.' and `del`=0'.$query);
while ($line = mysqli_fetch_array($result)) {

			if (file_exists($file_folder . $line['name'])) {
				
	if (is_file($file_folder .'logo.png')) {
		$stamp = imagecreatefrompng($file_folder .'logo.png');
		$image = imagecreatefromjpeg($file_folder . $line['name']);
		
		$exif = exif_read_data($file_folder . $line['name']);
		if (!empty($exif['Orientation'])) {
			    switch ($exif['Orientation']) {
        // Поворот на 180 градусов
        case 3: {
            $image = imagerotate($image,180,0);
            break;
        }
        // Поворот вправо на 90 градусов
        case 6: {
            $image = imagerotate($image,-90,0);
            break;
        }
        // Поворот влево на 90 градусов
        case 8: {
            $image = imagerotate($image,90,0);
            break;
        }
    }}
		imagecopy($image, $stamp,0, imagesy($image)-imagesy($stamp), 0, 0, imagesx($stamp), imagesy($stamp));
		imagejpeg ($image,'tmp/'.$line['name'].'_logo.jpg', 95);
			imagedestroy($image);
		echo $line['name'].'_logo.jpg;'.filesize('tmp/'.$line['name'].'_logo.jpg').';'; 
		readfile('tmp/'.$line['name'].'_logo.jpg');
	
		
	}			
				
				
				
				

        echo $line['name'].'.jpg;'.filesize($file_folder . $line['name']).';'; 
        readfile($file_folder . $line['name']);  
//$pos = strpos($line['name'],'.');
//$photo = substr($line['name'],0,$pos);
$pid=$line['id'];
$photo=$line['name'];
$mysqli->query('INSERT INTO down_photo VALUES("'.$pid.'","'.$photo.'") ON DUPLICATE KEY UPDATE photo = "'.$photo.'"');
        //$zip->addFile($file_folder . $line['name'],$line['name']); // добавляем файлы в zip архив
        
        //$flag = true;
} else {echo 'no';};
   
}
//if(!$flag){
//    $zip->addEmptyDir(" ");
//}

//$zip->close();

//if(file_exists($zip_name))
//{
// отдаём файл на скачивание
   // header('Content-type: application/zip');

    //readfile($zip_name);
// удаляем zip файл если он существует
    //unlink($zip_name);
//}

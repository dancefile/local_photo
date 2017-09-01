<?php
include("../../config.php");
/*
    Простое сжатие изображения
*/
if(isset($_GET['i'])){
    if(file_exists("min/".$_GET['i'])){
        header("Content-Disposition: inline; filename=".$_GET['i']); 
        header('Content-Type: image/jpeg');

        $min = imageCreateFromJpeg("./min/".$_GET['i']); 

        $exif = exif_read_data($config['foto'].$_GET['i']);
        if(!empty($exif['Orientation'])) {
            switch($exif['Orientation']) {
                case 8:
                    $min = imagerotate($min , 90 , 0);
                    break;
                case 3:
                    $min = imagerotate($min, 180 , 0);
                    break;
                case 6:
                    $min = imagerotate($min, -90 , 0);
                    break;
            }
        }
        imageJpeg($min);
    } else {
        header("Content-Disposition: inline; filename=".$_GET['i']); 
        header('Content-Type: image/jpeg');
        $filename = $config['foto'].$_GET['i'];
        $from = imageCreateFromJpeg($filename); 

        list($width, $height) = getimagesize($filename);
        $percent = 0.05;
        $new_width = $width * $percent;
        $new_height = $height * $percent;

        $to   = imageCreateTrueColor($new_width, $new_height); 
        imageCopyResampled(
            $to, $from, 0, 0, 0, 0, imageSX($to), imageSY($to), 
            imageSX($from), imageSY($from)
        ); 

        $exif = exif_read_data($filename);
        if(!empty($exif['Orientation'])) {
            switch($exif['Orientation']) {
                case 8:
                    $to = imagerotate($to , 90 , 0);
                    break;
                case 3:
                    $to = imagerotate($to, 180 , 0);
                    break;
                case 6:
                    $to = imagerotate($to, -90 , 0);
                    break;
            }
        }

        imageJpeg($to, "./min/".$_GET['i'], 100);
        imagedestroy($to);
    }
}
?>
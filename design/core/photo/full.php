<?php
include("../../config.php");
/*
    Простое сжатие изображения
*/
if(isset($_GET['i'])){
        header("Content-Disposition: inline; filename=".$_GET['i']); 
        header('Content-Type: image/jpeg');
        $filename = $config['foto'].$_GET['i'];

        $max = imageCreateFromJpeg($filename); 
        $exif = exif_read_data($filename);
        if(!empty($exif['Orientation'])) {
            switch($exif['Orientation']) {
                case 8:
                    $max = imagerotate($max , 90 , 0);
                    break;
                case 3:
                    $max = imagerotate($max, 180 , 0);
                    break;
                case 6:
                    $max = imagerotate($max, -90 , 0);
                    break;
            }
        }
        imageJpeg($max);
}


?>
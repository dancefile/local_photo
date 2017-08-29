<?
if (!isset($_GET['order']))  {exit;};
session_start();
include ('../db.php');
include('../lang.php');
function add_str_to_im($str,$size)
{global $y,$font,$im,$paper,$black;
$bbox = imageftbbox($size, 0, $font, $str);
$x =($paper-$bbox[2])/2;
$y=$y+intval(($bbox[1]-$bbox[7])*1.3);
imagefttext($im, $size, 0, $x, $y, $black, $font, $str);
}
$rs = $mysqli->query('SELECT * FROM settings where kkey="printer" or kkey="curence"') or die( mysql_error());
while ($line = mysqli_fetch_array($rs)) {
$price[$line['kkey']]=$line['value']; 	
}

$rs = $mysqli->query('SELECT * FROM zakaz where id='.$_GET['order']) or die( mysql_error());
while ($line = mysqli_fetch_array($rs)) {
$totalprice=$line['summa']; 	
}


$paper=384;
//$im = imagecreatetruecolor($paper, 26182);
$im = imagecreatetruecolor($paper, 900);
$black = imagecolorallocate($im, 0, 0, 0);
$white = imagecolorallocate($im, 255, 255, 255);
imagefilledrectangle($im, 0, 0, $paper, 26182, $white);// установка белого фона
$font = 'arial.ttf';
$y=0;
add_str_to_im(brendname,40);
add_str_to_im(url,26);
add_str_to_im(date("F j, Y, H:i:s"),20);
$y=$y+10;
add_str_to_im('Order #',20);
add_str_to_im($_GET['order'],100);
$y=$y+10;
add_str_to_im('Your price',20);
add_str_to_im($totalprice.' '.$price['curence'],80);
add_str_to_im('Thank you!',40);

$y=$y+70;
add_str_to_im('.',10);

imagejpeg($im,'../tmp\2.jpg',100);
imagedestroy($im);
unset($_SESSION['name']);
unset($_SESSION['cd']);
unset($_SESSION['a6']);
unset($_SESSION['a5']);
unset($_SESSION['a4']);
unset($_SESSION['comm']);
unset($_SESSION['comm']);
unset($_SESSION['mail']);
/*$post_var=array();
$post_var['foto_file']= base64_encode(file_get_contents('..\tmp\1.jpg'));			
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
    $result = file_get_contents('http://192.168.0.2/print.php', false, $context);*/
exec('C:\Apache24\htdocs\exe\print.exe C:\Apache24\htdocs\tmp\2.jpg "'.$price['printer'].'"');
//$com->print(20,0,0,brendname);
//$com->print(13,0,0,url);
//$com->print(10,0,0,date("F j, Y, H:i:s"));
//$com->print(50,0,0,$zid);
//$com->print(12,0,0,iconv('UTF-8','cp1251',total.': '.$line['summa'].' '.curence));
//$com->print(20,0,0,'Thank you');
//$com->finish;




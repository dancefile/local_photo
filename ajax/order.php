<?
session_start();

include ('../db.php');
include('../lang.php');
$totalprice=0;
function add_str_to_im($str,$size)
{global $y,$font,$im,$paper,$black;
$bbox = imageftbbox($size, 0, $font, $str);
$x =($paper-$bbox[2])/2;
$y=$y+intval(($bbox[1]-$bbox[7])*1.3);
imagefttext($im, $size, 0, $x, $y, $black, $font, $str);
	
}
$rs = $mysqli->query('SELECT * FROM settings where kkey="printer" or kkey="pricecd" or kkey="price10" or kkey="price15" or kkey="price20"  or kkey="curence"') or die( mysql_error());
while ($line = mysqli_fetch_array($rs)) {
$price[$line['kkey']]=$line['value']; 	
}

if (isset($_SESSION['login'])) {$login=$_SESSION['login'];} else {$login='guest';};
if (isset($_GET['paid']))  {$paid='1';} else {$paid='0';};
$cdflag=FALSE;
foreach ($_SESSION['name'] as $i => $value) {
if ($_SESSION['a6'][$i]==='') {$_SESSION['a6'][$i]=0;};
if ($_SESSION['a5'][$i]==='') {$_SESSION['a5'][$i]=0;};
if ($_SESSION['a4'][$i]==='') {$_SESSION['a4'][$i]=0;};
if ($_SESSION['cd'][$i]) $cdflag=TRUE;
$pricethis=$_SESSION['a6'][$i]*$price['price10']+$_SESSION['a5'][$i]*$price['price15']+$_SESSION['a4'][$i]*$price['price20']+$_SESSION['cd'][$i]*$price['pricecd'];
$totalprice=$totalprice+$pricethis;};
if (isset($_SESSION['mail'])) {$email=$_SESSION['mail'];} else $email='';
$rs = $mysqli->query('INSERT INTO zakaz (menedger,opl_sum,oplata,summa,ok,data,mail) Values ("'.$login.'","'.$totalprice.'",'.$paid.',"'.$totalprice.'",0,now(),"'.$email.'");') or die('error');
$zakazNomer = $mysqli->insert_id;
$echo1= '<h1>'.ordernamber.$zakazNomer.'<br>';
$echo1.= total.' '.$price['curence'].' '.$totalprice.' <br> ';
$echo1.=orderready;
$echo1.= '</h1>';
foreach ($_SESSION['name'] as $i => $value) {
$pricethis=$_SESSION['a6'][$i]*$price['price10']+$_SESSION['a5'][$i]*$price['price15']+$_SESSION['a4'][$i]*$price['price20']+$_SESSION['cd'][$i]*$price['pricecd'];
$rs=$mysqli->query('INSERT INTO foto (zakaz,name,cd,a6,a5,a4,price,coment) Values
('.$zakazNomer.',"'.$_SESSION['name'][$i].'",'.$_SESSION['cd'][$i].','.$_SESSION['a6'][$i].','.$_SESSION['a5'][$i].','.$_SESSION['a4'][$i].','.$pricethis.',"'.$_SESSION['comm'][$i].'");');
};
if ($price['printer']) {
$paper=384;
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
add_str_to_im(order,20);
add_str_to_im($zakazNomer,100);
$y=$y+10;
add_str_to_im(Your_price,20);
add_str_to_im($totalprice.' '.$price['curence'],80);

if ($cdflag && $email) {$y=$y+10;
	add_str_to_im(use_,20);
	add_str_to_im($email,18);
	add_str_to_im(to_download_your_fotos_at,20);
	add_str_to_im('dancefile.'.$domen.'/mail',25);
}

add_str_to_im(Thank_you,40);

$y=$y+20;
add_str_to_im($_SERVER['REMOTE_ADDR'],15);
$y=$y+70;
add_str_to_im('.',10);

imagejpeg($im,'../tmp\1.jpg',100);
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
exec('C:\Apache24\htdocs\exe\print.exe C:\Apache24\htdocs\tmp\1.jpg "'.$price['printer'].'"');
}

echo '<h1>'.ordernamber.$zakazNomer.'<br>';
echo total.' '.$totalprice.'  '.$price['curence'].'<br> ';
echo orderready;
echo  '</h1>';

//$com->print(20,0,0,brendname);
//$com->print(13,0,0,url);
//$com->print(10,0,0,date("F j, Y, H:i:s"));
//$com->print(50,0,0,$zid);
//$com->print(12,0,0,iconv('UTF-8','cp1251',total.': '.$line['summa'].' '.curence));
//$com->print(20,0,0,'Thank you');
//$com->finish;




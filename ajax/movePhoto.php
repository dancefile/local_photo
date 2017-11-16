<?php
session_start();
if(!$_SESSION['auth'])
{
    header("Location: ./admin_auth.php");
    die();
}
?>

<?php
$pid = $_GET['pid'];
$zidn = $_GET['zidn'];
$zid = $_GET['zid'];
include "../db.php";
include '../lang.php';

$result = $mysqli->query("UPDATE foto SET zakaz=$newZakazID where zakaz=$oldZakazID");
$rs = $mysqli->query('SELECT * FROM settings where kkey="pricecd" or kkey="price10" or kkey="price15" or kkey="price20"') or die( mysql_error());
while ($line = mysqli_fetch_array($rs)) {
	define ($line['kkey'],$line['value']);
	
}

//Move photo
$mysqli->query("UPDATE foto SET zakaz=$zidn where id=$pid");
include 'calc_total.php';
echo json_encode($array_price);
$zid=$zidn;
include 'calc_total.php';
<?php
session_start();
include '../db.php';

$rs = $mysqli->query('SELECT * FROM settings where kkey="pricecd" or kkey="price10" or kkey="price15" or kkey="price20"') or die( mysql_error());
while ($line = mysqli_fetch_array($rs)) {
	define ($line['kkey'],$line['value']);
	
} 

    $a6= $_GET['a6']==''? 0: $_GET['a6'];
    $a5 = $_GET['a5']==''? 0: $_GET['a5'];
    $a4 = $_GET['a4']==''? 0:$_GET['a4'];
    $cd = $_GET['cd'];
	
    $korprice = $_GET['korprice'];
    $coment =  $_GET['coment'];
    $pid = $_GET['pid'];
   // $price = $_GET['price'];
    $zid = $_GET['zid'];
	$korprice=($korprice=='') ? 0:$korprice;
    $mysqli->query("UPDATE foto SET a6=$a6, a5=$a5, a4=$a4, cd=$cd, korprice=$korprice, coment='$coment' where id=$pid");
	
include 'calc_total.php';	
echo json_encode($array_price);
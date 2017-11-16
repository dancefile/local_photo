<?php
session_start();
if(!$_SESSION['auth'])
{
    header("Location: ./admin_auth.php");
    die();
}

$oldZakazID= $_GET['oldZakazID'];
$newZakazID = $_GET['newZakazID'];
include "../db.php";
include '../lang.php';

$result = $mysqli->query("UPDATE foto SET zakaz=$newZakazID where zakaz=$oldZakazID");
$rs = $mysqli->query('SELECT * FROM settings where kkey="pricecd" or kkey="price10" or kkey="price15" or kkey="price20"') or die( mysql_error());
while ($line = mysqli_fetch_array($rs)) {
	define ($line['kkey'],$line['value']);
	
} 


$zid=$oldZakazID;
include 'calc_total.php';
$zid=$newZakazID;
include 'calc_total.php';

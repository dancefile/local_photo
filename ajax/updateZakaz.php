<?php
session_start();
if(!$_SESSION['auth'])
{
    header("Location: ./admin_auth.php");
    die();
}
include "../db.php";

if (isset($_POST['mail'])) {
	$mysqli->query('UPDATE zakaz SET mail="'.$_POST['mail'].'" where id="'.$_POST['id'].'"');
	exit;
};
	
$zid = $_GET['zid'];
$ok = $_GET['ok'];
$oplata= $_GET['oplata'];

$mysqli->query("UPDATE zakaz SET ok=$ok , oplata=$oplata where id=$zid");

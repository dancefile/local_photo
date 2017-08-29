<?php
session_start();
include "db.php";
include('lang.php');
if ($rs = $mysqli->query('SELECT * from `pass` where login="'.$_POST['login'].'" and pas="'.$_POST['password'].'"'))
while ($line = mysqli_fetch_array($rs)) {
    $_SESSION['auth'] = true;
	if ($line['adm']) $_SESSION['adm'] = true;
	$_SESSION['login']=$line['login'];
    header("Location: ./admin.php");
    die();
}
	echo '<a href="/index.php">'.mainpage.'</a><br><br>'; 
    echo "bad login info!";
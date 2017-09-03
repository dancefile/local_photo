<?php
session_start();
include "db.php";
include('lang.php');

//Удаляем все лишние пробелы, которые пользователи могли поставить случайно.
$login = trim($_POST['login']);
$password = trim($_POST['password']);

//Делаем запрос в бд
if ($rs = $mysqli->query('SELECT * from `pass` where login="'.$login.'" and pas="'.$password.'"'))
while ($line = mysqli_fetch_array($rs)) {
	$_SESSION['auth'] = true;
	if ($line['adm']) $_SESSION['adm'] = true;
	$_SESSION['login']=$line['login'];
    	header("Location: ./admin.php");
    	die();
}

echo '<a href="/index.php">'.mainpage.'</a><br><br>'; 
echo "bad login info!";

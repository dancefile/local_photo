<?
session_start(); 
include "db.php";
if (isset($_POST['login'])){

$sql='SELECT login FROM pass where login=\''.$_POST['login'].'\' and pas=\''.$_POST['pas'].'\';';
 $rs = mysql_query($sql) or die('������ �� ������: ' . mysql_error());
if ($line = mysql_fetch_array($rs, MYSQL_ASSOC)) {
$_SESSION['login']=$_POST['login'];
    $_SESSION['auth'] = true;
header('Location: http://'.$_SERVER['HTTP_HOST'].'/basket.php');
};
};

if (isset($_GET['d'])){
unset($_SESSION['login']);	
unset($_SESSION['auth']);
unset($_SESSION['adm']);
//print_r($_SERVER);
//echo 'Location: http://'.$_SERVER['HTTP_HOST'];
header ('Location: http://'.$_SERVER['HTTP_HOST']);
};
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>Login</title>
<style type="text/css">
<!--
.style1 {font-size: 45px}
.style2 {font-size: 25px}
-->
</style>
</head>

<body bgcolor="#000000" text="#FFFFFF" link="#FFFFFF" vlink="#FFFFFF" alink="#666666">
<div align="center">
<form action="" method="post">
login <select name="login">
<?

$sql = 'SELECT login FROM pass order by login;';
 $rs = mysql_query($sql) or die('������ �� ������: ' . mysql_error());
while ($line = mysql_fetch_array($rs, MYSQL_ASSOC)) {
echo '<option>'.$line["login"].'</option>';
};
?>
</select><br />password <input name="pas" type="password" />

</form><br /><br /><span class="style1">
<a href="/basket.php">Back to your basket</a>
<? //echo 'http://'.$_SERVER['SERVER_NAME'].'/basket.php'?>
</div>
</body>
</html>
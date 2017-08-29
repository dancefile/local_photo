<? 
session_start();
if(!$_SESSION['auth']) {header("Location: ./admin_auth.php");die();}
include ('db.php');
include('lang.php');
if(isset($_POST['deleteuser'])) {
DelUser($_POST['id']);
header("Location: /settings.php?a=admin");
}
if(isset($_POST['save'])) {
SaveBd($_POST['kkey'], $_POST['value']);
header("Location: /settings.php?a=other");
}
if(isset($_POST['savepass'])) {
SavePass($_POST['login'], $_POST['pass'], $_POST['id']);
header("Location: settings.php?a=admin");
}
if(isset($_POST['createuser'])) {
SaveUser($_POST['newlogin'], $_POST['newpass']);
}
?>
<!DOCTYPE html>
<html>
<head>
 <meta charset="UTF-8">
 <title>Admin</title>
 <script src="./js/jquery-1.11.1.min.js"></script>
 <script src="./js/admin.js"></script>
 <link rel="stylesheet" href="./css/table.css">
 <link rel="stylesheet" type="text/css" href="./css/admin.css"/>
 </head>
<body >
<style type="text/css">
	   A:visited {
    color: rgb(4,95,152); /* Цвет посещенных ссылок */
   }
   A:active {
    color: rgb(4,95,152); /* Цвет активных ссылок */
	}
	a {
	text-decoration:none;
	color: rgb(4,95,152);
   }
   input  {
   	border-radius: 10px;
height: 30px;
    width:220px;
    padding:5px 8px;
   }
   	:-moz-placeholder {
    color: blue;
}
body {
  font-family:Arial, Helvetica, sans-serif;
  font-family:Corbel,'Myriad Pro',Arial, Helvetica, sans-serif;
}
</style>
	<a href="/admin.php">Admin</a><br><br><br><br> 
	<?
	function SelectBd($kkey)
{global $mysqli;
 if ($stmt=$mysqli->query("SELECT * FROM settings WHERE kkey='$kkey'"))
 while ($row = mysqli_fetch_array($stmt)) {
 echo "<form action='' method='POST'>$kkey<input type='hidden' value='".$row['kkey']."' name='kkey'/><input type='text' value='".$row['value']."' name='value'/><input type='submit' name='save' value='Сохранить'/></form>";
}}
	function SelectPass($id)
{global $mysqli;
 if ($stmt=$mysqli->query("SELECT * FROM pass WHERE id='$id'"))
 while ($row = mysqli_fetch_array($stmt)) {
 echo "<form action='' method='POST'><input type='text' name='login' value='".$row['login'] ."'/><input type='password' value='".$row['pas']."' name='pass'/><input type='hidden' value='".$row['id']."' name='id'/><input type='submit' name='savepass' value='Сохранить'/></form>";
}}
	function SaveBd($kkey, $value) {
		global $mysqli;
		$mysqli->query("UPDATE settings SET value='".$mysqli->real_escape_string($value)."' WHERE kkey = '$kkey'");
	}
	function SavePass($login, $pas, $id) {
		global $mysqli;
		$mysqli->query("UPDATE pass SET login='".$mysqli->real_escape_string($login)."', pas='".$mysqli->real_escape_string($pas)."' WHERE id = '$id'");
	}
		function SaveUser($newlogin, $newpass) {
		global $mysqli;
		$sql = "INSERT INTO pass (login,pas) VALUES('$newlogin','$newpass')";
		if ($mysqli->query($sql) === TRUE) {
    echo "Новый пользователь успешно создан";
}
}
			function DelUser($id) {
		global $mysqli;
		if($mysqli->query("DELETE FROM pass WHERE id='$id'")===TRUE) {
	}
	}
	function DeleteUser($id)
{global $mysqli;
 if ($stmt=$mysqli->query("SELECT * FROM pass WHERE id='$id'"))
 while ($row = mysqli_fetch_array($stmt)) {
 echo "<form action='' method='POST'><input type='text' name='login' value='".$row['login'] ."' disabled='disabled'/><input type='password' value='".$row['pas']."' name='pass' disabled='disabled'/><input type='hidden' value='".$row['id']."' name='id'/><input type='submit' name='deleteuser' value='Удалить'/></form>";
}}
switch ($_GET['a']) {
	case 'admin':
	echo "<form method='POST'><input type='text' name='newlogin' placeholder='Логин нового пользователя'><input type='text' name='newpass' placeholder='Пароль нового пользователя'><input type='submit' name='createuser' value='Добавить пользователя'/></form>";
if ($result = $mysqli->query('SELECT * FROM `pass`'))
	echo "<table><tr><th>login</th><th></th><th></th></tr>";
while ($line = mysqli_fetch_array($result)) {
	echo "<tr><td>".$line['login']."</td><td><a href='settings.php?a=r&id=".$line['id']."'/>Изменить</a></td><td><a href='settings.php?a=y&id=".$line['id']."'/>Удалить</a></td></tr><br>";
};
 ?>	
	
<?		break;
	case 'other':
echo "<table><tr><th>kkey</th><th>value</th><th></th></tr>";
if ($stmt=$mysqli->query("SELECT * FROM settings WHERE kkey not in ('last_report_date','last_pic','last_report_num')"))
 while ($row = mysqli_fetch_array($stmt)) {
			echo "<tr><td>".$row['kkey']."</td><td>".$row['value']."</td><td><a href='settings.php?a=e&kkey=".$row['kkey']."'/>Изменить</a></td></tr></form>";
}
echo "</table>";

		break;
	case 'flash':
		
		break;		
	case 'e':
      SelectBd($_GET['kkey']);
	break;
	case 'r':
		SelectPass($_GET['id']);
		break;
		case 'y':
			DeleteUser($_GET['id']);
			break;
	default: 
	?>
	
<a href="/settings.php?a=admin">Пароли</a><br><br>
 <a href="/settings.php?a=flash">Скачка</a><br><br>
 <a href="/settings.php?a=other">Прочие</a><br><br>	
		
		
<?		break;
}
?>
 </body>
</html>
<? 
session_start();
if(!$_SESSION['auth']) {header("Location: ./admin_auth.php");die();}
include ('db.php');
//include('lang.php');
include('class/multilanguage.php');
$langarray['admin']=array('Админ','Admin');
$langarray['download']=array('Загрузки','Download');
$langarray['photographers']=array('Фотографы','Photographers');
$langarray['passwords']=array('Пароли','Passwords');
$langarray['other']=array('Прочее','Other');
$langarray['new_path_to_the_memory_card']=array('Новый путь к карте памяти','New path to the memory card');
$langarray['Upload']=array('Добавить','Upload');
$langarray['the_path']=array('Путь','Path');
$langarray['New_code_for_the_photographer']=array('Новый код фографа','New code for the photographer');
$langarray['New_user_password']=array('Новый пароль пользователя','New user password');
$langarray['Edit']=array('Изменить','Edit');
$langarray['Upload']=array('Добавить','Upload');
$langarray['New_name_of_photographer']=array('Новое имя фотографа','New name of photographer');
$langarray['Save']=array('Сохранить','Save');
$langarray['login']=array('Логин','login');
$langarray['New_user_login']=array('Логин нового пользователя','New user login');
$langarray['Code']=array('Код','Code');
$langarray['delete']=array('Удалить','Delete');
$langarray['name']=array('Имя','Name');
$langarray['cdsile']=array('Скидка','Sale');
$langarray['curence']=array('Валюта','Currency');
$langarray['iddancefile']=array('id конкурса на сайте','id of the contest on the site');
$langarray['n']=array('Название турнира','Name of the tournament');
$langarray['path_to_folder']=array('Путь к архиву','The path to the archive');
$langarray['price10']=array('Цена печати 10х15','The price of printing is 10x15');
$langarray['price15']=array('Цена печати 15х20','The price of printing is 15x20');
$langarray['price20']=array('Цена печати 20х30','The price of printing is 20x30');
$langarray['pricecd']=array('Цена файла','Price of file');
$langarray['printer']=array('Чековый принтер','Receipt printer');
$langarray['New_user_created_successfully']=array('Новый пользователь успешно создан','New user created successfully');
$langarray['Add_user']=array('Добавить пользователя','Add user');
$langarray['Hashtag']=array('Хэштег:','Hashtag:');
$langarray['']=array('','');
$langarray['']=array('','');
$langarray['']=array('','');
$langarray['']=array('','');
$langarray['']=array('','');


$newlanguage= new Multilanguage($langarray);

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


if(isset($_POST['savefotograf'])){
$mysqli->query("UPDATE `fotografers` SET kod='".$mysqli->real_escape_string($_POST['kod'])."', name='".$mysqli->real_escape_string($_POST['name'])."' WHERE id = '".$_POST['id']."'");
header("Location: settings.php?a=fotograf");
}
if(isset($_POST['saveurl'])) {
$_POST['url']=trim($_POST['url']);
$last=substr($_POST['url'],-1);
if ($last == "/" || $last == "\\") $_POST['url'] = substr($_POST['url'],0,-1); 
$mysqli->query("UPDATE `flash` SET url='".$mysqli->real_escape_string($_POST['url'])."' WHERE id = '".$_POST['id']."'");
header("Location: settings.php?a=flash");
}
if(isset($_POST['createuser'])) {
SaveUser($_POST['newlogin'], $_POST['newpass']);
}
if(isset($_POST['createpath'])) {
$_POST['url']=trim($_POST['newpath']);
$last=substr($_POST['newpath'],-1);
if ($last == "/" || $last == "\\") $_POST['newpath'] = substr($_POST['newpath'],0,-1);
$mysqli->query("INSERT INTO `flash` (url) VALUES('".$_POST['newpath']."')");
header("Location: settings.php?a=flash");
}
if(isset($_POST['createfotograf'])) {
$mysqli->query("INSERT INTO `fotografers` (kod,name) VALUES('".$_POST['newfotografkod']."','".$_POST['newfotografname']."')");
header("Location: settings.php?a=fotograf");
}

if(isset($_GET['delflash'])) 
{
	$mysqli->query("DELETE FROM `flash` WHERE id=".$_GET['id']);
	header("Location: settings.php?a=flash");
}

if(isset($_GET['delfotograf'])) 
{
	$mysqli->query("DELETE FROM `fotografers` WHERE id=".$_GET['id']);
	header("Location: settings.php?a=fotograf");
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
	<a href="/admin.php"><?=$newlanguage->admin?></a><br><br><br><br> 
	<?
	function SelectBd($kkey)
{global $mysqli,$newlanguage;
 if ($stmt=$mysqli->query("SELECT * FROM settings WHERE kkey='$kkey'"))
 while ($row = mysqli_fetch_array($stmt)) {
 echo "<form action='' method='POST'>$kkey<input type='hidden' value='".$row['kkey']."' name='kkey'/><input type='text' value='".$row['value']."' name='value'/><input type='submit' name='save' value='$newlanguage->Save'/></form>";
}}


	function Selectfotografers($id)
{global $mysqli,$newlanguage;
 if ($stmt=$mysqli->query("SELECT * FROM `fotografers` WHERE id='$id'"))
 while ($row = mysqli_fetch_array($stmt)) {
 echo "<form action='' method='POST'><input type='text' name='kod' value='".$row['kod'] ."'/><input type='text' name='name' value='".$row['name'] ."'/><input type='hidden' value='".$row['id']."' name='id'/>
 <input type='submit' name='savefotograf' value='$newlanguage->Save'/></form>";
}}
	
	function SelectFlash($id)
{global $mysqli,$newlanguage;
 if ($stmt=$mysqli->query("SELECT * FROM `flash` WHERE id='$id'"))
 while ($row = mysqli_fetch_array($stmt)) {
 echo "<form action='' method='POST'><input type='text' name='url' value='".$row['url'] ."'/><input type='hidden' value='".$row['id']."' name='id'/><input type='submit' name='saveurl' value='$newlanguage->Save'/></form>";
}}

	function SelectPass($id)
{global $mysqli,$newlanguage;
 if ($stmt=$mysqli->query("SELECT * FROM pass WHERE id='$id'"))
 while ($row = mysqli_fetch_array($stmt)) {
 echo "<form action='' method='POST'><input type='text' name='.$newlanguage->login.' value='".$row['login'] ."'/><input type='password' value='".$row['pas']."' name='pass'/><input type='hidden' value='".$row['id']."' name='id'/><input type='submit' name='savepass' value='$newlanguage->Save'/></form>";
}}
	function SaveBd($kkey, $value) {
		global $mysqli,$newlanguage;
		$mysqli->query("UPDATE settings SET value='".$mysqli->real_escape_string($value)."' WHERE kkey = '$kkey'");
	}
	function SavePass($login, $pas, $id) {
		global $mysqli,$newlanguage;
		$mysqli->query("UPDATE pass SET login='".$mysqli->real_escape_string($login)."', pas='".$mysqli->real_escape_string($pas)."' WHERE id = '$id'");
	}
		function SaveUser($newlogin, $newpass) {
		global $mysqli,$newlanguage;
		$sql = "INSERT INTO pass (login,pas) VALUES('$newlogin','$newpass')";
		if ($mysqli->query($sql) === TRUE) {
    echo $newlanguage->New_user_created_successfully;
}
}
			function DelUser($id) {
		global $mysqli;
		if($mysqli->query("DELETE FROM pass WHERE id='$id'")===TRUE) {
	}
	}
	function DeleteUser($id)
{global $mysqli,$newlanguage;
 if ($stmt=$mysqli->query("SELECT * FROM pass WHERE id='$id'"))
 while ($row = mysqli_fetch_array($stmt)) {
 echo "<form action='' method='POST'><input type='text' name='login' value='".$row['login'] ."' disabled='disabled'/><input type='password' value='".$row['pas']."' name='pass' disabled='disabled'/><input type='hidden' value='".$row['id']."' name='id'/><input type='submit' name='deleteuser' value='$newlanguage->delete'/></form>";
}}
switch ($_GET['a']) {
	case 'admin':
	echo "<form method='POST'><input type='text' name='newlogin' placeholder='$newlanguage->New_user_login'><input type='text' name='newpass' placeholder='$newlanguage->New_user_password'><input type='submit' name='createuser' value='$newlanguage->Add_user'/></form>";
if ($result = $mysqli->query('SELECT * FROM `pass`'))
	echo "<table><tr><th>$newlanguage->login</th><th></th><th></th></tr>";
while ($line = mysqli_fetch_array($result)) {
	echo "<tr><td>".$line['login']."</td><td><a href='settings.php?a=r&id=".$line['id']."'/>$newlanguage->Edit</a></td><td><a href='settings.php?a=y&id=".$line['id']."'/>$newlanguage->delete</a></td></tr><br>";
};
 ?>	
	
<?		break;
	case 'other':
echo "<table><tr><th></th><th></th><th></th></tr>";
if ($stmt=$mysqli->query("SELECT * FROM settings WHERE kkey not in ('last_report_date','last_pic','last_report_num')"))
 while ($row = mysqli_fetch_array($stmt)) {
			if ($row['kkey']!='md5' && $row['kkey']!='cdsile') echo "<tr><td>".$newlanguage->__get($row['kkey'])."</td><td>".$row['value']."</td><td><a href='settings.php?a=e&kkey=".$row['kkey']."'/>$newlanguage->Edit</a></td></tr></form>";
}
echo "</table>";

		break;
	case 'flash':
	echo "<form method='POST'><input type='text' name='newpath' placeholder=$newlanguage->new_path_to_the_memory_card><input type='submit' name='createpath' value=$newlanguage->Upload></form>";
if ($result = $mysqli->query('SELECT * FROM `flash`'))
	echo "<table><tr><th>$newlanguage->the_path</th><th></th></tr>";
while ($line = mysqli_fetch_array($result)) {
	echo "<tr><td>".$line['url']."</td><td><a href='settings.php?a=s&id=".$line['id']."'/>$newlanguage->Edit</a></td><td><a href='settings.php?delflash&id=".$line['id']."'/>$newlanguage->delete</a></td></tr><br>";
};
echo "</table>"; 			
		
		
		break;
	case 'fotograf':
	echo "<form method='POST'><input type='text' name='newfotografkod' placeholder='$newlanguage->New_code_for_the_photographer'> <input type='text' name='newfotografname' placeholder='$newlanguage->New_name_of_photographer'><input type='submit' name='createfotograf' value='$newlanguage->Upload'/></form>";
if ($result = $mysqli->query('SELECT * FROM `fotografers`'))
	echo "<table><tr><th>$newlanguage->Code</th><th>$newlanguage->name</th><th></th></tr>";
while ($line = mysqli_fetch_array($result)) {
	echo "<tr><td>".$line['kod']."</td><td>".$line['name']."</td><td><a href='settings.php?a=f&id=".$line['id']."'/>$newlanguage->Edit</a></td><td><a href='settings.php?delfotograf&id=".$line['id']."'/>$newlanguage->delete</a></td></tr><br>";
};
echo "</table>"; 			
		
			
		break;		
	case 'e':
      SelectBd($_GET['kkey']);
	break;
	case 'r':
	  SelectPass($_GET['id']);
	  break;	
	  case 's':
	  SelectFlash($_GET['id']);
	  break;
	  case 'f':
	  Selectfotografers($_GET['id']);
	  break;	  
	case 'y':
	  DeleteUser($_GET['id']);
	  break;
	  

	  
	default: 
		
	 if ($stmt=$mysqli->query('SELECT * FROM settings WHERE kkey="md5"'))
 while ($row = mysqli_fetch_array($stmt)) {
 echo $newlanguage->Hashtag.' '.$row['value'].'<br><br>';}	
	?>
<a href="/settings.php?a=flash"><?=$newlanguage->download?></a><br><br>
<a href="/settings.php?a=fotograf"><?=$newlanguage->photographers?></a><br><br>	
<a href="/settings.php?a=admin"><?=$newlanguage->passwords?></a><br><br>
<a href="/settings.php?a=other"><?=$newlanguage->other?></a><br><br>	
		
		
<?		break;
}
?>
 </body>
</html>
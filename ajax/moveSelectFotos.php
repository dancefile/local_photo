<?
include ('../db.php');
include('../lang.php');

	$str2='';
	function echolink($id,$name){
		global $str2,$u;
		if ($id!=$u) $str2= $str2. '<span class="link0 flash" id="'.$id.'">'.$name.'</span> | ';
		else {$str2=  $str2.'  '.$name.' | ';};
	}

	function findperant($id){
		global $mysqli;
		if ($id!=0) {
	 $query = 'SELECT name,parent FROM url where  id=\''.$id.'\';';
	 $rs = $mysqli->query($query) or die( mysqli_error());		
	if ($line = mysqli_fetch_array($rs))	{
		echolink($id,$line["name"]);
		findperant($line['parent']);}	
			
		};
	}

$u='0';
if (isset($_POST['lastId'])) $u= $_POST['lastId'];
$echo_menu= '<div class="" vertical-align="baselin">';

//if ($u<>'') {$echo_menu.= ' | <a href="/gal.php">'.$n[0].'</a> | ';} else {$echo_menu.=' | '.$n[0];};
findperant($u);
if (isset($_POST['add'])) {$mysqli->query('INSERT INTO `url` (`name`, `parent`) VALUES ("'.$_POST['add'].'", '.$u.');');};
echo $echo_menu.$str2.'<span class="link0 flash" id="0">'.mainpage.'</span></div><br><input id="adK'.$u.'" class="inputAddKat" type="text" value="" placeholder="Add"><br>';
 if ($rs = $mysqli->query('SELECT * FROM `url` WHERE `parent` = '.$u)) 
 while ($line = mysqli_fetch_array($rs)) {
 echo '&nbsp;&nbsp;&nbsp;<img src="img/moveFoto.gif" alt="Переместить"  title="Переместить" class="link_i" id="img'.$line['id'].'"/> <span class="link flash" id="'.$line['id'].'">'.$line['name'].'</span><br>';
  
 }?>


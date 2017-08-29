<?

include ('../db.php');
include('../lang.php');

	$str2='';
	function echolink($id,$name){
		global $str2,$u;
		if ($id!=$u) $str2= $str2. '<span class="link flash" id="'.$id.'">'.$name.'</span> | ';
		else {$str2=  $str2.' <img src="img/m_i.png" alt="Переместить"  title="Переместить" class="link_i" id="img'.$id.'"/> '.$name.' | ';};
	}

	function findperant($id){
		global $mysqli;
		if ($id!=0) {
	 if ($rs = $mysqli->query('SELECT name,parent FROM url where  id=\''.$id.'\';'))		
	if ($line = mysqli_fetch_array($rs))	{
		echolink($id,$line["name"]);
		findperant($line['parent']);
	}	
		};
	}

$u=3;
if (isset($_POST['lastId'])) $u= $_POST['lastId'];
$echo_menu= '<div class="" vertical-align="baselin">';
//if ($u<>'') {$echo_menu.= ' | <a href="/gal.php">'.$n[0].'</a> | ';} else {$echo_menu.=' | '.$n[0];};
findperant($u);
echo $echo_menu.$str2.'<span class="link flash" id="0">'.mainpage.'</span></div><br>';
 if ($rs = $mysqli->query('SELECT * FROM `url` WHERE `parent` = '.$u)) 
 while ($line = mysqli_fetch_array($rs)) {
 echo '&nbsp;&nbsp;&nbsp;<img src="img/m_i.png" alt="Переместить"  title="Переместить" class="link_i" id="img'.$line['id'].'"/> <span class="link flash" id="'.$line['id'].'">'.$line['name'].'</span><br>';
  
 }
  ?>
 
<br>
<input type="text" id="addkat" per="<?=$u?>" placeholder="новая папка"/><br>
<select id='photografer'>
	<? 
	$addfotograf=TRUE;
		 $rs2 = $mysqli->query('SELECT * FROM `fotografers`') or die( mysqli_error());		
	while ($line2 = mysqli_fetch_array($rs2))	{
		$select='';
		if ($_POST['fotog']==$line2['kod']) {$select=" selected";$addfotograf=FALSE;}
	echo '<option value="'.$line2['id'].'"'.$select.'>'.$line2['kod'].' | '.$line2['name'].'</option>';
	}
	if ($addfotograf) {
	$rs3 = $mysqli->query('INSERT INTO `fotografers` (`id`, `kod`, `name`) VALUES (NULL, "'.$_POST['fotog'].'", "'.$_POST['fotog'].'");') or die( mysqli_error());	
		echo '<option value="'.$mysqli->insert_id.'" selected>'.$_POST['fotog'].'</option>';
	}
	?>

    </select>

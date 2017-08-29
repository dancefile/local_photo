<? 
if (is_file('install.php')) {header("Location: install.php");exit;};
session_start(); 
include "db.php";
include('lang.php');
$u='0';
if (isset($_GET["url"])) $u= $_GET["url"];
		function array_s($str,$mask) {
		  foreach ($mask as $item) 
				//echo $str.'-'.$item
		if (0===strripos($str,$item)) {return true; }
																		  return false; 

		};
?>

<html>
<head>
	<title>Foto</title>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<script type="text/javascript" src="./js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="./js/jquery.lazy.min.js"></script>
	<script type="text/javascript" src="./js/gal.js"></script>
	<script type="text/javascript">
var basket=false;
</script>
	<link rel="stylesheet" type="text/css" href="./css/gal.css" media="screen" />
</head>
<body>
	<div class="header">
		<div id="fixedBox">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="40">
						
					
						<? include "langlist.php"; ?>
					</td>
					<td>
						<?php
							$str2='';
								function echolink($id,$name){
									global $str,$str2,$u;
									if ($id!=$u) $str2= '<a href="?url='.$id.'">'.$name.'</a> | '.$str2;
									else {$str2=  $name.' '.$str2;};
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

								$result = $mysqli->query('SELECT * FROM settings where kkey="n"');
								$line = mysqli_fetch_array($result);
								$cuont=0;

								$echo_menu= '<span class="style1">';
								if ($u<>'') {$echo_menu.= '<a href="/">'.$line['value'].'</a> | ';} else {$echo_menu.=' | '.$line['value'];};
								findperant($u);
								echo $echo_menu.$str2.'</span><p>';

								$id_url=$u;
								if (isset($_SESSION['page']) && $_SESSION['page']) {$page = 0;} else {
								if (isset($_GET['page']))
								$page = ($_GET['page']); else $page = 1;
								$rows_per_page = 2000;
								$from = ($page-1) * $rows_per_page;
								$res=$mysqli->query("SELECT count(*) FROM fotos where url='$id_url'");
								$row=mysqli_fetch_row($res);
								$total_rows=$row[0]; 	
								$total_pages = ceil($total_rows / $rows_per_page);
								$page_str='';
								if ($total_rows > $rows_per_page) {
									
								 $page_str.= '<span class="style2">'.page.': ';
								for($i = 1; $i <= $total_pages; $i++) {
								  if (($i) == $page) {
								    $page_str.= "" . $i . " ";
								  } else {
								    $page_str.= '<a href="?url='.urlencode($u).'&page=' . $i . '">' . $i . '</a> ';
								  }
								}; $page_str.= '</span> &nbsp;&nbsp;&nbsp;&nbsp;';

								echo $page_str;
								};};
								if (!isset($_GET['serach'])){
								?>
								
								<span class="style2">Sort by 
									<?
									if (isset($_SESSION['sort'])) {$sort='id';
									echo '<span id="sortTime" class="sort">time</span> | <span id="sortumber">number</span>';
									} else {
										$sort='data';
									echo '<span id="sortTime">time</span> | <span id="sortumber" class="sort">number</span>';	
										
									}
								
									 echo '</span>';
								}
								
							 if (isset($_SESSION['login'])) {echo '<a href="/login.php?d=1" class="magleft">'.$_SESSION['login'].'</a>';}; echo '<span id="malevich"></span>'; ?>	
							
					</td>
					<td>
						<form class="searchForm" action="" method="get">
							<input name="serach" id="serach"  type="text" value="<? if (isset($_GET['serach'])){echo $_GET['serach'];}; ?>" size="40" placeholder=" <?=Search?>"> 
							<input class="btnSearch" type="submit" value="<? echo Go; ?>" onClick="submit(); this.disabled = true; " >
						</form>
					</td><td width="5px"></td><?
													$count_b=0;
		if (isset($_SESSION['name'])) {$count_b=count($_SESSION['name']);}
						 if (!isset($_GET['serach'])){

						if (isset($_SESSION['login'])) {echo '<td width="200px"><div id="appst2"><div><span id="edButon">Редактирование </span> <span class="pages_enable';
						if (!$page) echo ' edit';
						echo '"> Страницы </span>
						</div>
						<div id="editBs"><img src="img/del.gif" id="delfoto"> <img src="img/moveFoto.gif" id="movefoto"> </div>
						</div></td>';};}
						?>
					
					<td width="100px">
						<div id="appst">
							<center>
								<?= ShoppingCart; ?> (<span id="aa4files"><?=$count_b;?></span>)
							</center>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>

	<?
	if (!isset($_GET['serach'])){
		$query = 'SELECT id,name FROM url where  parent=\''.$u.'\'  and name != "NO" ORDER BY `url`.`name` ASC;';
		 $rs = $mysqli->query($query) or die('error');
		while ($line = mysqli_fetch_array($rs)) {
		echo '<a href="?url='.$line["id"].'" class="link1">'.$line["name"].'</a>';
		if (isset($_SESSION['login'])) { echo '&nbsp;&nbsp;&nbsp;
		<input id="inp'.$line["id"].'" class="inputLink" type="text" value="'.$line["name"].'"/>&nbsp;&nbsp;&nbsp;<img src="img/edit.jpg" id="edt'.$line["id"].'" class="imLink"/>&nbsp;&nbsp;&nbsp;
		<img src="img/cut.jpg"  id="cut'.$line["id"].'" class="imLink"/>&nbsp;&nbsp;&nbsp;<img src="img/del.jpg"  id="del'.$line["id"].'" class="imLink"/> ';};
		echo '<br>';
		$cuont++;
		}
		if (isset($_SESSION['login'])) { 
		if(isset($_SESSION['cutkat']) && $_SESSION['cutkat']) {
			$str2='';
		findperant($_SESSION['cutkat']);
		echo '<img src="img/cut.jpg"  id="pas'.$u.'" class="imLink"/>'.$str2.'<spane id="cle'.$u.'" class="imLink"> сбросить</spane><br><br>';};
		echo '<input id="adK'.$u.'" class="inputAddKat" type="text" value="'.$line["name"].'" placeholder="Add"/><br>';
		}

}

echo '<span id="vl-img">';
		if (isset($_GET['serach'])){
			$i=0;  $mask=array();
		$search= array(",", ".", "/", "|", "\\", "*");
		$mask= explode(" ", preg_replace('/[\s]{2,}/', ' ', str_replace ($search , ' ' , $_GET['serach'])));
		//foreach ($searh_m as  $value) if (strlen ($value)>3) $mask[]=$value;
		//$mask = array("0123x","0124x","1235x","1245x","1235x","1267x","1765x","1275x");
		$sql='';
		if (count ($mask)>0) {

		foreach ($mask as $key => $value) 
		$sql.= ','.$value;
		$sql = 'SELECT id,url FROM fotos where id in ('.substr($sql,1) .') order by id;';
		$rs = $mysqli->query($sql);
		$ldn=-1;
		$lurl='-';
		 $url = 0;
			while ($line = mysqli_fetch_array($rs)) {
				$vl='';
				if (isset($_SESSION['name']) && in_array($line['id'],$_SESSION['name'])) {$vl='1';};
				$cuont++;
				if ($url!=$line['url']) {$str2='';$url=$line['url'];findperant($url); echo '<br>'.$str2.'<br>';}
				echo '<img class="lazy img'.$vl.'" title="'.$line['id'].'.jpg" data-src="/ps/'.$line['id'].'.jpg" src="img/foto.jpg">';
			};}} else {




		$sql = 'SELECT id FROM fotos where url='.$id_url.' order by '.$sort;
		if ($page) $sql .= ' LIMIT '.$from.', '.$rows_per_page.';';
		 $rs2 = $mysqli->query($sql) or die( mysql_error());
		 
			while ($line = mysqli_fetch_array($rs2)) {
				$vl='';
				if (isset($_SESSION['name']) && in_array($line['id'],$_SESSION['name'])) {$vl='1';};
				$cuont++;
				echo '<img class="lazy img'.$vl.'" title="'.$line['id'].'.jpg" data-src="/ps/'.$line['id'].'.jpg" src="img/foto.jpg">';
			};
		
			}		
			echo '</span><br><br>';		
		if ($page) echo '<br><br>'.$page_str.'<br>';
		if ($cuont==0) {echo '<br>'.folderempty.'<br>';}; 


	?>

	<br><br>
	<div class="modalWindow">
		<center id="center">
			<table height="100%">
				<tr>
					<td width="100px">
						<img src="img/left.png" class="g_but" id="left_b"/>
					</td>
					<td align="center">
						<div class="crop" id="divimg">
							<img src="img/nopictures.png" id="img_l"/>
							<img src="img/foto.jpg" id="img"/>
							<span id="fancybox-title-over"></span>
						</div>
						<br>
						
					</td>
					<td width="100px">
						<img src="img/right.png" class="g_but" id="right_b"/>
					</td>
				</tr>
			</table>
		</center>
	</div>
	<div class="curtain"></div>	
	<div id="move_wrapper"></div>
</body>

<script type="text/javascript">
	var lastclick=-1;
	var count_b=<?=$count_b ?>;
	var Addphoto='<?=Addphoto; ?>';
	var ALREADYincart='<?=ALREADYincart; ?>';
	var deletephoto='<?=deletephoto ?>';

	//console.log('');
</script>

</html>

<? 
session_start(); 
include "db.php";
include('lang.php');
$u='0';
if (isset($_GET["url"])) $u= $_GET["url"];
?>

<html>
<head>
	<title>DanceFile</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script type="text/javascript" src="./js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="./js/jquery.lazy.min.js"></script>
	<script type="text/javascript" src="./js/gal.js"></script>
	<link rel="stylesheet" type="text/css" href="./css/gal.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="./css/search.css" media="screen" />
</head>

<body>
	<div class="header">
		<div id="fixedBox">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="120">
						<? if (isset($_SESSION['login'])) {echo '<a href="/login.php?d=1">'.$_SESSION['login'].'</a><br>';}; ?>
						<br>
						<?
							include "langlist.php";
						?>
					</td>
					<td>
						<?php
							$cuont=0;
						?>
						<a href="/index.php" class="style2">
							<? echo mainpage; ?>
						</a>
					</td>
					<td>
						<form class="searchForm" action="search.php" method="ger">
							<input name="serach" id="serach"  type="text" value="<? if (isset($_GET['serach'])){echo $_GET['serach'];}; ?>" size="40"> 
							<input type="submit" value="<? echo Go; ?>" onClick="submit(); this.disabled = true; " >
						</form>
					</td>
					<td style="width: 100px;">
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
		echo '<span id="vl-img">';
		 
		function array_s($str,$mask) {
		  foreach ($mask as $item) 
				//echo $str.'-'.$item
		if (0===strripos($str,$item)) {return true; }
																		  return false; 

		};


		$i=0;  $mask=array();
		if (isset($_GET['serach'])){
		$search= array(",", ".", "/", "|", "\\", "*");
		$mask= explode(" ", preg_replace('/[\s]{2,}/', ' ', str_replace ($search , ' ' , $_GET['serach'])));
		//foreach ($searh_m as  $value) if (strlen ($value)>3) $mask[]=$value;
		//$mask = array("0123x","0124x","1235x","1245x","1235x","1267x","1765x","1275x");
		$sql='';
		if (count ($mask)>0) {

		foreach ($mask as $key => $value) 
		$sql.= ' OR id = '.$value;
		$sql = 'SELECT id FROM fotos where  ('.substr($sql,4) .') order by id;';
		$rs = $mysqli->query($sql);
		$ldn=-1;
		$lurl='-';
		 
			while ($line = mysqli_fetch_array($rs)) {
				$vl='';
				if (isset($_SESSION['name']) && in_array($line['id'],$_SESSION['name'])) {$vl='1';};
				$cuont++;
				echo '<img class="lazy img'.$vl.'" title="'.$line['id'].'.jpg" data-src="/ps/'.$line['id'].'.jpg" src="img/foto.jpg">';
			};}}
		echo '</span><br><br>


		';				
		echo '<br><br>'.$page_str.'<br>';
		if ($cuont==0) {echo '<br>'.folderempty.'<br>';}; 

		$count_b=0;
		if (isset($_SESSION['name'])) {$count_b=count($_SESSION['name']);}
	?>

	<br>
	<br>
	<div class="modalWindow">
		<center id="center">
			<table height="100%">
				<tr>
					<td width="100px">
						<img src="img/left.png" class="g_but" id="left_b"/>
					</td>
					<td align="center">
	 					<div class="crop" id="divimg">
	 						<img src="img/loading.gif" id="img_z"/>
	 						<img src="img/loading.gif" id="img"/>
	 					</div>
	 					<br>
	 					<span id="fancybox-title-over"></span>
	 				</td>
	 				<td width="100px">
	 					<img src="img/right.png" class="g_but" id="right_b"/>
	 				</td>
	 			</tr>
	 		</table>
	 	</center>
	</div>
	<div class="curtain"></div>	
		
</body>

	<script type="text/javascript">
		var count_b=<?=$count_b ?>;
		var Addphoto='<?=Addphoto; ?>';
		var ALREADYincart='<?=ALREADYincart; ?>';
		var deletephoto='<?=deletephoto ?>';

		//console.log('');
	</script>

</html>

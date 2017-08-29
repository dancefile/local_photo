<? session_start(); 
	include ("db.php");
	include('lang.php');
?>

<html>
<head>
	<title>DanceFile</title>
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<script type="text/javascript" src="./js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="./js/jquery.lazy.min.js"></script>
	<script src="./js/basket.js" type="text/javascript"></script>
	<script type="text/javascript" src="./js/gal.js"></script>
	<link rel="stylesheet" href="./css/basket.css" type="text/css">
	<script type="text/javascript">
	var basket=true;
		<? 
			echo 'var cartempty="'.cartempty.'";';
			$rs = $mysqli->query('SELECT * FROM settings where kkey="pricecd" or kkey="price10" or kkey="price15" or kkey="price20"  or kkey="curence"') or die( mysql_error());
			while ($line = mysqli_fetch_array($rs)) {
				if ($line['kkey']=='curence') {echo 'var '.$line['kkey'].'="'.$line['value'].'";'; define ('curence',$line['value']);} else
			echo 'var '.$line['kkey'].'='.$line['value'].';'; 	
			} 
		?>
	</script>
</head>
<body>
	<div class="header">
		<div id="fixedBox">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width="120">
				<?php
					if (isset($_SESSION['login'])) {echo '<a href="/login.php?d=1">'.$_SESSION['login'].'</a><br>';};// else {echo '<a href="/login.php">login</a><br>';};
					echo '<br>';
					include "langlist.php";
					$cuont=0;
				?>
			</td>
			<td>
				<?
					echo '<a href="/index.php">'.mainpage.'</a> | <a href="'.$_SERVER['HTTP_REFERER'].'">'.back.'</a>';
				?>
			</td>
			<td>
				<? 
					echo total.': <span id="total"></span> '.curence.'<br>'.photos.'<span id="count"></span><br>';
					if (isset($_SESSION['login'])) {?> <br clear="all"><input id="paid" type="checkbox" checked> <?=Paid?><? 
					 }; 
				?>
			</td>
			<td>
				<span class="link" id="del"><? echo CleanCart; ?></span>
				<?
					if (isset($_SESSION['login'])) {?><br><img src="img/moveFoto.gif" id="movefoto"> переместить <? }; ?> 
			</td>
		</tr>
	</table>
</div>
</div>
	<?
		if (isset($_SESSION['name'])){echo '<span id="basket"><br><span class="link" onClick="cd();" oncontextmenu="nocd(); return false">'.allonCD.'</span><br><br>'; 
		$k=0;
		foreach ($_SESSION['name'] as $i => $value) {
			$k++;
		 	echo '
		 	<div class="photo" id="foto'.$i.'">
		 		<img class="img" title="'.$_SESSION['name'][$i].'.jpg" src="/ps/'.$_SESSION['name'][$i].'.jpg" hspace="5" vspace="10">
		 	<div style="text-align:left;">
		 		<span>'.digital.'</span>
		 		<input type="checkbox"  id="cd'.$i.'" class="count_foto cd" value="" ';
					if ($_SESSION['cd'][$i]) echo 'checked';
						echo ' onClick="price();">
				<span id="cd'.$i.'b">
					<img src="img/load2_emtry.gif"/>
				</span>
			</div>
			<br>
			<div style="text-align:left;"><span>Print</span></div>
			A6&nbsp;&nbsp;<a  href=\'javascript:minus("a6'.$i.'");\'><img src="img/minus.jpg" align="top"></a> <input type="text" id="a6'.$i.'" class="count_foto input" size="2" value="'.$_SESSION['a6'][$i].'"> <a  href=\'javascript:plus("a6'.$i.'");\'><img src="img/plus.jpg" align="top"></a> <span id="a6'.$i.'b">&nbsp;<img src="img/load2_emtry.gif"/>&nbsp;</span><br>
			A5&nbsp;&nbsp;<a  href=\'javascript:minus("a5'.$i.'");\'><img src="img/minus.jpg" align="top"></a> <input type="text" id="a5'.$i.'" class="count_foto input" size="2" value="'.$_SESSION['a5'][$i].'"> <a  href=\'javascript:plus("a5'.$i.'");\'><img src="img/plus.jpg" align="top"></a> <span id="a5'.$i.'b">&nbsp;<img src="img/load2_emtry.gif"/>&nbsp;</span><br>
			A4&nbsp;&nbsp;<a  href=\'javascript:minus("a4'.$i.'");\'><img src="img/minus.jpg" align="top"></a> <input type="text" id="a4'.$i.'" class="count_foto input" size="2" value="'.$_SESSION['a4'][$i].'"> <a  href=\'javascript:plus("a4'.$i.'");\'><img src="img/plus.jpg" align="top"></a> <span id="a4'.$i.'b">&nbsp;<img src="img/load2_emtry.gif"/>&nbsp;</span><br>
			<div style="text-align:left; margin-top: 15px;">'.comment.'&nbsp;<span id="comm'.$i.'b">&nbsp;<img src="img/load2_emtry.gif"/>&nbsp;</span><input name="comm['.$i.']" type="text" size="8" id="comm'.$i.'" value="'.$_SESSION['comm'][$i].'" class="count_foto i_kom"></div>';
		 	echo '<div style="text-align:left; margin-top: 15px;">'.price.'<span style="font-size:20px;" id="price'.$i.'"  class="">0</span></div><br>
			<span id="del'.$i.'" class="link del">'.deletephoto.'</span></div>';
		};
	?>
	<br>
	<br clear="all">
	<br>
	<div style="text-align: center;">
		E-mail: 
		<input type="text" id="mail" value="<?=$_SESSION['mail']; ?>" class="count_foto i_mail">
		<span id="mailb">&nbsp;<img src="img/load2_emtry.gif"/>&nbsp;</span>
		<br><br>
		<button id="send" class="buttom"><? echo Makeorder; ?></button>
		<br><br><br>
	</div>
	
	<?
		} else {if (isset($echo1)) {echo $echo1;} else {echo '<br><br><div style="text-align:center;font-size:30px;">'.cartempty.'</div>';};};
	?>
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
	<div id="move_wrapper"></div>
</body>
</html>
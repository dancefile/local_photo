<? 
if (is_file('install.php')) {header("Location: install.php");exit;};
session_start(); 
include "db.php";
include('lang.php');
$u='0';
$shortView=false;
if (isset($_GET['serach'])){$shortView=TRUE;};
if (isset($_GET['basket'])){$shortView=TRUE;};
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
	<script type="text/javascript" src="./js/gal.js?ver=2"></script>
	<script type="text/javascript">
var basket=false;
var fotograf=[];
<?
					$rs = $mysqli->query('SELECT * FROM fotografers') or die( mysql_error());
			while ($line = mysqli_fetch_array($rs)) {
			echo 'fotograf['.$line['id'].']="'.$line['name'].'";'; 	
			} 
			?>
</script>
	<link rel="stylesheet" type="text/css" href="./css/gal.css?ver=1" media="screen" />
</head>
<body onscroll="return false"><? if (isset($_GET['basket'])){ ?>
		<script type="text/javascript">
		basket=true;
		<? 
			echo 'var cartempty="'.cartempty.'";';
			$rs = $mysqli->query('SELECT * FROM settings where kkey="pricecd" or kkey="price10" or kkey="price15" or kkey="price20"  or kkey="curence"') or die( mysql_error());
			while ($line = mysqli_fetch_array($rs)) {
				if ($line['kkey']=='curence') {echo 'var '.$line['kkey'].'="'.$line['value'].'";'; define ('curence',$line['value']);} else
			echo 'var '.$line['kkey'].'='.$line['value'].';'; 	
			} 
			
	
			
		?>
	</script><? } ;?>
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
								$rows_per_page = 1500;
								$from = ($page-1) * $rows_per_page;
								$res=$mysqli->query("SELECT count(*) FROM fotos where url='$id_url'");
								$row=mysqli_fetch_row($res);
								$total_rows=$row[0]; 	
								$total_pages = ceil($total_rows / $rows_per_page);
								$page_str='';
								if ($total_rows > $rows_per_page) {
									
								 $page_str.= '<span class="style3">'.page.': ';
								for($i = 1; $i <= $total_pages; $i++) {
								  if (($i) == $page) {
								    $page_str.= "" . $i . " ";
								  } else {
								    $page_str.= '<a href="?url='.urlencode($u).'&page=' . $i . '">' . $i . '</a> ';
								  }
								}; $page_str.= '</span> &nbsp;&nbsp;&nbsp;&nbsp;';

								echo $page_str;
								};};
								if (!$shortView){
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
						 if (!$shortView){

						if (isset($_SESSION['login'])) {echo '<td width="200px"><div id="appst2"><div><span id="edButon">Редактирование </span> <span class="pages_enable';
						if (!$page) echo ' edit';
						echo '"> Страницы </span>
						</div>
						<div id="editBs"><img src="img/del.gif" id="delfoto"> <img src="img/moveFoto.gif" id="movefoto"> </div>
						</div></td>';};}
						 
						 
						 
						 if (isset($_GET['basket'])){
						 	
						 						echo '<td>'.total.': <span id="total"></span> '.curence.'<br>'.photos.'<span id="count"></span><br>';
					if (isset($_SESSION['login'])) {?> <br clear="all"><input id="paid" type="checkbox" checked> <?=Paid?><? 
					 };
							echo '</td>';?>
							<td>
				<span class="link" id="del"><? echo CleanCart; ?></span>
				<?
					if (isset($_SESSION['login'])) {?><br><img src="img/moveFoto.gif" id="movefoto"> переместить <? }; ?> 
			</td><?
						 }else {
						?>
						
						
					
					<td width="100px">
						<div id="appst">
							<center>
								<?= ShoppingCart; ?> (<span id="aa4files"><?=$count_b;?></span>)
							</center>
						</div>
					</td>
					<? } ?>
				</tr>
			</table>
		</div>
	</div>

	<?
	if (!$shortView){
		$query = 'SELECT id,name FROM url where  parent=\''.$u.'\'  and name != "NO" ORDER BY `url`.`name` ASC;';
		 $rs = $mysqli->query($query) or die('error');
		while ($line = mysqli_fetch_array($rs)) {
		echo '<a href="?url='.$line["id"].'" class="link1">'.$line["name"].'</a>';
		if (isset($_SESSION['login'])) { echo '&nbsp;&nbsp;&nbsp;
		<input id="inp'.$line["id"].'" class="inputLink" type="text" value="'.$line["name"].'"/>&nbsp;&nbsp;&nbsp;<img src="img/edit.jpg" id="edt'.$line["id"].'" class="imLink"/>&nbsp;&nbsp;&nbsp;
		<img src="img/cut_.jpg"  id="cut'.$line["id"].'" class="imLink"/>&nbsp;&nbsp;&nbsp;<img src="img/del.jpg"  id="del'.$line["id"].'" class="imLink"/> ';};
		echo '<br>';
		$cuont++;
		}
		if (isset($_SESSION['login'])) { 
		if(isset($_SESSION['cutkat']) && $_SESSION['cutkat']) {
			$str2='';
		findperant($_SESSION['cutkat']);
		echo $str2.'<spane id="pas'.$u.'" class="imLink"/> вставить </spane>'.'<spane id="cle'.$u.'" class="imLink"> сбросить</spane><br><br>';};
		echo '<input id="adK'.$u.'" class="inputAddKat" type="text" value="'.$line["name"].'" placeholder="Add"/><br>';
		}

}

		if (isset($_GET['serach'])){
			$i=0;  $mask=array();
		$search= array(",", ".", "/", "|", "\\", "*");
		$mask= explode(" ", preg_replace('/[\s]{2,}/', ' ', str_replace ($search , ' ' , $_GET['serach'])));
		$sql='';
		if (count ($mask)>0) {

		foreach ($mask as $key => $value) 
		$sql.= ','.$value;
		$sql = 'SELECT id,url,photografer,data FROM fotos where id in ('.substr($sql,1) .') order by id;';
		$rs = $mysqli->query($sql);
		$ldn=-1;
		$lurl='-';
		 $url = 0;
			while ($line = mysqli_fetch_array($rs)) {
				$vl='';
				if (isset($_SESSION['name']) && in_array($line['id'],$_SESSION['name'])) {$vl='1';};
				$cuont++;
				if ($url!=$line['url']) {$str2='';$url=$line['url'];findperant($url); echo '<br>'.$str2.'<br>';}
				echo '<img ph="'.$line['photografer'].'" data="'.$line['data'].'" class="lazy img'.$vl.' vlimg" title="'.$line['id'].'.jpg" data-src="/ps/'.$line['id'].'.jpg" src="img/foto.jpg">';
			};}};
			
			
			if (isset($_GET['basket'])){
				if (isset($_SERVER['HTTP_REFERER'])) echo '<div><a href="'.$_SERVER['HTTP_REFERER'].'">'.back.'</a></div>';


				
		if (isset($_SESSION['name'])){echo '<span id="basket"><br><span class="link" onClick="cd();" oncontextmenu="nocd(); return false">'.allonCD.'</span><br><br>'; 
		$k=0;
		foreach ($_SESSION['name'] as $i => $value) {
			$k++;
		 	echo '
		 	<div class="photo" id="foto'.$i.'">
		 	
		 		<img class="img vlimg" title="'.$_SESSION['name'][$i].'.jpg" src="/ps/'.$_SESSION['name'][$i].'.jpg" hspace="5" vspace="10">
		 	<div class="bas">
		 		<span>'.digital.'</span>
		 		<input type="checkbox"  id="cd'.$i.'" class="count_foto cd" value="" ';
					if ($_SESSION['cd'][$i]) echo 'checked';
						echo ' onClick="price();">
				<span id="cd'.$i.'b">
					<img src="img/load2_emtry.gif"/>
				</span>
			</div>
			<br>
			<div  class="bas"><span>Print</span></div>
			A6&nbsp;&nbsp;<a  href=\'javascript:minus("a6'.$i.'");\'><img src="img/minus.jpg" align="top"></a> <input type="text" id="a6'.$i.'" class="count_foto input" size="2" value="'.$_SESSION['a6'][$i].'"> <a  href=\'javascript:plus("a6'.$i.'");\'><img src="img/plus.jpg" align="top"></a> <span id="a6'.$i.'b">&nbsp;<img src="img/load2_emtry.gif"/>&nbsp;</span><br>
			A5&nbsp;&nbsp;<a  href=\'javascript:minus("a5'.$i.'");\'><img src="img/minus.jpg" align="top"></a> <input type="text" id="a5'.$i.'" class="count_foto input" size="2" value="'.$_SESSION['a5'][$i].'"> <a  href=\'javascript:plus("a5'.$i.'");\'><img src="img/plus.jpg" align="top"></a> <span id="a5'.$i.'b">&nbsp;<img src="img/load2_emtry.gif"/>&nbsp;</span><br>
			A4&nbsp;&nbsp;<a  href=\'javascript:minus("a4'.$i.'");\'><img src="img/minus.jpg" align="top"></a> <input type="text" id="a4'.$i.'" class="count_foto input" size="2" value="'.$_SESSION['a4'][$i].'"> <a  href=\'javascript:plus("a4'.$i.'");\'><img src="img/plus.jpg" align="top"></a> <span id="a4'.$i.'b">&nbsp;<img src="img/load2_emtry.gif"/>&nbsp;</span><br>
			<div  class="bas">'.comment.'&nbsp;<input name="comm['.$i.']" type="text" size="8" id="comm'.$i.'" value="'.$_SESSION['comm'][$i].'" class="count_foto i_kom"><span id="comm'.$i.'b">&nbsp;<img src="img/load2_emtry.gif"/>&nbsp;</span></div>';
		 	echo '<div  class="bas">'.price.'<span style="font-size:20px;" id="price'.$i.'"  class="">0</span></div><br>
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
	
	<?} else {if (isset($echo1)) {echo $echo1;} else {echo '<br><br><div style="text-align:center;font-size:30px;">'.cartempty.'</div>';};};
			
			}
			if (!$shortView){




		$sql = 'SELECT id,photografer,data FROM fotos where url='.$id_url.' order by '.$sort;
		if ($page) $sql .= ' LIMIT '.$from.', '.$rows_per_page.';';
		 $rs2 = $mysqli->query($sql) or die( mysql_error());
		 
			while ($line = mysqli_fetch_array($rs2)) {
				$vl='';
				if (isset($_SESSION['name']) && in_array($line['id'],$_SESSION['name'])) {$vl='1';};
				$cuont++;
				echo '<img ph="'.$line['photografer'].'" data="'.$line['data'].'" class="lazy img'.$vl.' vlimg" title="'.$line['id'].'.jpg" data-src="/ps/'.$line['id'].'.jpg" src="img/foto.jpg">';
			};
		
			}		
			echo '<br><br>';	
			
			//	
		
		
		if ($page) {if ($page<$total_pages) {$curent_page=$page+1; echo '<br><center><br><a href="?url='.urlencode($u).'&page=' .$curent_page. '" class="style4">>>> '.next_page.' >>></a><br></center>';}
			echo '<br>'.$page_str.'<br>';}
	if ($cuont==0 && !isset($_GET['basket'])) {echo '<br>'.folderempty.'<br>';}; 



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
							<span id="photografer-over"></span>
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
	<? if (isset($_GET['basket'])){?>
	var Addphoto='';
	var ALREADYincart='';
	var deletephoto='';			
			
		<? } else{ ?>
	var Addphoto='<?=Addphoto; ?>';
	var ALREADYincart='<?=ALREADYincart; ?>';
	var deletephoto='<?=deletephoto ?>';

		<? }; ?>
			var fotografer='<?=fotografer ?>';
</script>

</html>

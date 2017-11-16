<? 
session_start();
//$_SESSION['lang']=1;
if(!$_SESSION['auth']) {header("Location: ./admin_auth.php");die();}
include ('db.php');
//include('lang.php');
include('class/multilanguage.php');
$langarray['managerlogout']=array(' Выход ','logout ');
$langarray['Shoppingbasket']=array('Корзина','Basket');
$langarray['Settings']=array('Настройки','Settings');
$langarray['Statistics']=array('Статистика','Statistics');
$langarray['update_maps']=array('Обновить карты памяти','update memorystick');
$langarray['Refresh']=array('Обновить','Refresh');
$langarray['updatephotosonthesite']=array('обновить фото на сайте','update photos on the site');
$langarray['MakeCache']=array('Создать миниатюры к фото','Make Cache');
$langarray['Send_mail']=array('Отправить письма','Send mail');
$langarray['Refresh']=array('Обновление','Refresh');
$langarray['openorder']=array('открыть заказ №','open order #');
$langarray['sum']=array('Сумма','Sum');
$langarray['payment']=array('Оплата','Paid');
$langarray['ready']=array('Готов','Ready');
$langarray['data']=array('Дата','Data');
$langarray['manager']=array('Мэнеджер','Manager');
$langarray['operations']=array('','Operations');
$langarray['oplache']=array('Оплаченные','Paid');
$langarray['enable_filter']=array('Включить фильтр','Enable filter');
$langarray['send_mail']=array('Отправить на почту','Send mail');
$langarray['Show_not_deleted']=array('Показывать не удаленные','Show not deleted');
$langarray['Show_Deleted']=array('Показать удаленные','Show Deleted');
$langarray['Recover']=array('Востановить','Recover');
$langarray['Delete']=array('Удалить','Delete');
$langarray['']=array('','');
$langarray['']=array('','');
$langarray['']=array('','');
$newlanguage= new Multilanguage($langarray);
if (isset($_GET['lang'])) {
	switch ($_GET['lang']) {
		case 'r':
			$newlanguage->setLang(0);
			break;
		case 'e':
			$newlanguage->setLang(1);
			break;
	}
}


?>
<!DOCTYPE html>
<html>
<head>
 <meta charset="UTF-8">
 <title>Admin</title>
 <script src="./js/jquery-1.11.1.min.js"></script>
 <script src="./js/admin.js"></script>
 <link rel="stylesheet" type="text/css" href="./css/admin.css"/>
 </head>
<body >

	<script language="JavaScript">
	$( document ).ready(function() {
	checkChange();
	});
	var Sendmail="<?=$newlanguage->send_mail?>"
		var MakeCache="<?=$newlanguage->MakeCache?>"
		var Recover="<?=$newlanguage->Recover?>"
		var Delete="<?=$newlanguage->Delete?>"
        var showDeleted = <?php
            if(isset($_GET['showDeleted'])){
                echo 1;
            }else
                echo 0;
        ?>; 
        
                function deleteZakaz(id){
            var recover = 0;
            if(showDeleted==0){
                recover = 1;
            }
            $.get( "ajax/deleteZakaz.php?", {zid:id,recover:recover } )
                .done(function( data ) {
                    if(data.indexOf("error")!=-1)
                        alert("error!");
                    else {
                        checkChange();
                    }
                });
        }
        
        </script>
	<a href="/">DanceFile</a> | 
<?
echo '<a href="/login.php?d=1">'.$_SESSION['login'].' '.$newlanguage->managerlogout.' </a> | <a href="/settings.php">'.$newlanguage->Settings.'</a>| <a href="/index.php?url=-1">'.
$newlanguage->Shoppingbasket.'</a>| <a href="/statistics.php">'.$newlanguage->Statistics.'</a> | 
<a href="?lang=r">русский</a> | <a href="?lang=e">english</a><br><br>';
?>
<button onclick="renewflash()"><?=$newlanguage->update_maps?></button>
<table><tr><td valign="top">
<table width="250px"><tr><td id='flash'>

</td></tr>
</table></td><td>
	
	<?
echo '<a href="/dancefile.php?lib" target="_blank">'.$newlanguage->updatephotosonthesite.'</a>'

?>
<br><br><?=$newlanguage->MakeCache?>
<div id="makeCache"><button onclick="makeCache()"><?=$newlanguage->MakeCache?></button></div> <br>
<?
echo $newlanguage->send_mail.'
<div id="sendMail"><button onclick="sendMail()">'.$newlanguage->send_mail.'</button></div> <br>
';?>
	 <form action="edit.php" method="get" target="_blank">
    <?=$newlanguage->openorder?> <input type="text" name="id"></form>
	<form action="">
    <input type="checkbox" id="cready" onclick="checkChange()"><?=$newlanguage->ready?>
    <input type="checkbox" checked id="cpayd" onclick="checkChange()"><?=$newlanguage->oplache?>
    <input type="checkbox" checked id="cenable" onclick="checkChange()"><?=$newlanguage->enable_filter?><br>

</form>
	<button onclick="checkChange()"><?=$newlanguage->Refresh?></button><br><br>
	<?
	if(isset($_GET['showDeleted'])){
        echo "<a href='./admin.php'>$newlanguage->Show_not_deleted</a>";
    }else
        echo "<a href='./admin.php?showDeleted'>$newlanguage->Show_Deleted</a>";
        ?>
<table id="tbl1" border="3">
	
	
	
	
	
	
	
	
	
    <tr align="center">
        <th>#</th>
        <th><?=$newlanguage->sum?></th>
        <th><?=$newlanguage->payment?></th>
        <th><?=$newlanguage->ready?></th>
        <th><?=$newlanguage->data?></th>
        <th><?=$newlanguage->manager?></th>
        <th><?=$newlanguage->operations?></th>
    </tr>
    <tbody id="tbody">
    </tbody>
</table><br>
	
	</td></tr></table>
<div id="move_wrapper"></div>
</body>
</html>
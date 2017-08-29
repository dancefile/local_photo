<? 
session_start();
if(!$_SESSION['auth']) {header("Location: ./admin_auth.php");die();}
include ('db.php');
include('lang.php');
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
	<script>
        var showDeleted = <?php
            if(isset($_GET['showDeleted'])){
                echo 1;
            }else
                echo 0;
        ?>; </script>
	<a href="/">DanceFile</a> | 
<?
echo '<a href="/login.php?d=1">'.$_SESSION['login'].' log out</a> | <a href="/settings.php">Настройки</a><br><br>';
?>
<button onclick="renewflash()">Обновить карты</button>
<table><tr><td valign="top">
<table><tr><td id='flash'>

</td></tr>
<tr><td id='under'>

</td></tr></table></td><td>
	
	<?
	$iddancefile=0;
if ($result = $mysqli->query('SELECT * FROM settings where kkey="iddancefile"'))
while ($line = mysqli_fetch_array($result)) {
$iddancefile=$line['value'];
}

if($iddancefile) echo '<a href="/dancefile.php?lib" target="_blank">обновить фото на сайте</a><br><br>'

?>
<br><br>Make Cache
<div id="makeCache"><button onclick="makeCache()">Make Cache</button></div> <br>
<?
if($iddancefile) echo '
<br><br>Send Mail
<div id="sendMail"><button onclick="sendMail()">Send mail</button></div> <br>
';?>
	 <form action="edit.php" method="get" target="_blank">
    open order # <input type="text" name="id"></form>
	<form action="">
    <input type="checkbox" id="cready" onclick="checkChange()">Ready
    <input type="checkbox" checked id="cpayd" onclick="checkChange()">Oplacheno
    <input type="checkbox" checked id="cenable" onclick="checkChange()">Enable filter<br>

</form>
	<button onclick="checkChange()">Refresh</button><br><br>
<table id="tbl1" border="3">
	
	
	
	
	
	
	
	
	
    <tr align="center">
        <th>#</th>
        <th>Sum</th>
        <th>Payment</th>
        <th>Ready</th>
        <th>Data</th>
        <th>Manager</th>
        <th>Operations</th>
    </tr>
    <tbody id="tbody">
    </tbody>
</table><br>
	
	</td></tr></table>
<div id="move_wrapper"></div>
</body>
</html>
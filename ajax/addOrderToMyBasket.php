<?php
session_start();

include ('../db.php');
$id = $_GET['bid'];
if(!isset($_SESSION['baskets'])) {
    $_SESSION['baskets'] = array();
}
//$_SESSION['baskets']=array();
$result = $mysqli->query("SELECT * FROM  `foto` where zakaz=$id and del=0");

while ($line = mysqli_fetch_array($result)) {
$in_basket=false;	
	if(isset($_SESSION['name'])) { foreach ($_SESSION['name'] as $i => $value) {
	if ($line['name']==$value  && $line['url']==$_SESSION['url'][$i]){$in_basket=TRUE;};
	};
}
		if (!$in_basket) {
$_SESSION['name'][]=$line['name'];
$_SESSION['url'][]=$line['url'];
$_SESSION['cd'][]=$line['cd'];
$_SESSION['a6'][]=$line['a6'];
$_SESSION['a5'][]=$line['a5'];
$_SESSION['a4'][]=$line['a4'];
$_SESSION['comm'][]=$line['comm'];

	};
	
 //   foreach($_SESSION['name'] as $bask){
       // if($bask['id']==$line['id']){
        	
           // echo json_encode($_SESSION['baskets']);
        //    return;
       // }
   //   echo  
    //}
    ///$count =count($_SESSION['baskets']);

  //  $_SESSION['baskets'][$count]['url']=$line['url'];
 //   $_SESSION['baskets'][$count]['name']=$line['name'];
  // $_SESSION['baskets'][$count]['ip']=$line['ip'];
//    $_SESSION['baskets'][$count]['data']=$line['data'];
  ////  $_SESSION['baskets'][$count]['id']=$line['id'];

   
}
//echo json_encode($in_basket);
?>
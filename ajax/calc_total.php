<?


	$array_foto=array();
	$array_price=array();
$result = $mysqli->query("SELECT `id`,`cd`, `a6`, `a5`, `a4`, `korprice`, `price`, `del`  from foto where zakaz=$zid");
    $cdcount  =0;
    while ($line = mysqli_fetch_array($result)) {
    	if (!$line['del']) $cdcount=$cdcount+$line['cd'];
    	$array_foto[$line['id']]['cd']=$line['cd'];
		$array_foto[$line['id']]['a6']=$line['a6'];
		$array_foto[$line['id']]['a5']=$line['a5'];
		$array_foto[$line['id']]['a4']=$line['a4'];
		$array_foto[$line['id']]['korprice']=$line['korprice'];
		$array_foto[$line['id']]['price']=$line['price'];
        $array_foto[$line['id']]['del']=$line['del'];
    }
	$discaunt=1;
     //if ($cdsile) {
     //   if	($cdcount>2) {$discaunt=0.9;};
     //   if	($cdcount>4) {$discaunt=0.8;};
     //   if	($cdcount>9) {$discaunt=0.7;};};
        $total=0;
      foreach ($array_foto as $key => $value) {
      	$price=pricecd*$discaunt*$value['cd']+price10*$value['a6']+price15*$value['a5']+price20*$value['a4']+$value['korprice'];
      	if (!$value['del']) $total=$total+$price;
      	$array_price['foto'][$key]=$price;
      	if ($price!=$value['price'])
		{
		
$result = $mysqli->query("UPDATE foto set price=$price where id=$key");
		};
		
      //	echo $price.'-';//$value['price'];
		
	  }  
        	

$result = $mysqli->query("UPDATE zakaz set summa=$total where id=$zid");
$array_price['total']=$total;



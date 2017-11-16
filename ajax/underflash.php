<?
set_time_limit(120);
include ('../db.php');
include('../lang.php');
$arr['time']=60000;
$arr['str']=0;
$result = $mysqli->query('SELECT * FROM settings where kkey="path_to_folder"');
$line = mysqli_fetch_array($result);
$path_to_folder=rtrim(iconv('UTF-8','cp1251',$line['value']), '\\/');

function MoveImg($dir)
{ global $IdImg,$EIdImg,$path_to_folder,$fileStr;
	if (is_dir($dir)) {
		$cdir = scandir($dir); 
		foreach ($cdir as $key => $f) 
   			{ 
				if ('.'<>$f & '..'<>$f &  $f<>'trash'&  $f<>'NO') {
					if (is_dir(rtrim($dir,'/\\').'/'.$f)) MoveImg(rtrim($dir,'/\\').'/'.$f); else if (strripos($f,'.jpg')){
						rename ($dir.'/'.$f, $path_to_folder.'/'.$IdImg);
						$fileStr.=$path_to_folder.'\\'.$IdImg.'|C:\Apache24\htdocs\ps\\'.$IdImg.'.jpg
';
						$IdImg++;
						if ($IdImg>=$EIdImg) return;
}}}}}




function SearchImg($dir)
{ global $imgCount;
	if (is_dir($dir)) if ($dh=opendir($dir))
		{while ($f=readdir($dh)) {
			if ('.'<>$f & '..'<>$f &  $f<>'trash'&  $f<>'NO') {
			if (is_dir(rtrim($dir,'/\\').'/'.$f)) SearchImg(rtrim($dir,'/\\').'/'.$f); else if (strripos($f,'.jpg')){
			$imgCount++;
			if ($imgCount>20) return;
}}}}}



if ($rs = $mysqli->query('SELECT * FROM `flash` where toId<>0 and (`time` < now() or `time` is null)'))
 while ($line = mysqli_fetch_array($rs)) {
	$mysqli->query('UPDATE `flash` SET `time` = (now() + INTERVAL 3 MINUTE) WHERE `flash`.`id` = '.$line['id'].';');
	$imgCount=0;
	SearchImg($line['url']);
	$arr['str']=$imgCount;
	$arr['flashid']=$line['id'];
	if ($imgCount) {
		$sql='';
		for ($i=0; $i < $imgCount; $i++) { 
		$sql.='('.$line['toId'].','.$line['photografer'].'),';	
		}
	$addId=0;
	if ($sql!='') {if ($mysqli->query('INSERT INTO `dancefile`.`fotos` (`url`,`photografer`) VALUES '.substr($sql, 0,-1))) 
		$addId=$mysqli->insert_id;
		}
	$fileStr='';
	$IdImg=$addId;
	$EIdImg=$imgCount+$IdImg;
	MoveImg($line['url']); 
	$nameTextFile='flash'.rand().'.txt';
	$file = fopen("../tmp/$nameTextFile", "w");
	fwrite($file, $fileStr); //пишем по указателю свои данные//chr(255)
	fclose($file); 
	shell_exec('C:/Apache24/htdocs/exe/jpeg_exe C:/Apache24/htdocs/tmp/'.$nameTextFile);
	unlink('C:/Apache24/htdocs/tmp/'.$nameTextFile);
	$arr['time']=10;
	} else {
	$mysqli->query('UPDATE `dancefile`.`flash` SET `toId` = 0 WHERE `flash`.`id` = '.$line['id'].';');
	$arr['time']=60000;
	$arr['str']=-1;
};
 
 $mysqli->query('UPDATE `flash` SET `time` = NULL WHERE `flash`.`id` = '.$line['id'].';');
 }



//$arr['str']='ok';
echo json_encode($arr);
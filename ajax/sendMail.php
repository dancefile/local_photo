<?
ini_set('upload_max_filesize', '60M');     
ini_set('max_execution_time', '999');
ini_set('memory_limit', '128M');
ini_set('post_max_size', '60M');
include "../db.php";
include('../lang.php');
//	$ftp_server = '43.252.178.2';
//$ftp_user_name = 'artandan';
//$ftp_user_pass = '61E4Jwyz7a';
$iddancefile=0;
if ($result = $mysqli->query('SELECT * FROM settings where kkey="iddancefile"'))
if ($line = mysqli_fetch_array($result)) {$iddancefile=$line['value'];}

$result = $mysqli->query('SELECT * FROM settings where kkey="path_to_folder"');
if ($line = mysqli_fetch_array($result)) $path_to_folder=$line['value'];

        $result = $mysqli->query('SELECT * FROM `zakaz` WHERE `mailStatus` = 1 limit 1');

       if ($line = mysqli_fetch_array($result)) {
       $zakazId=	$line['id'];
		   $mail=$line['mail'];

		      $result = $mysqli->query('SELECT * FROM `foto` WHERE `zakaz` = '.$zakazId.' AND `cd` = 1 AND `sendedmail` = 0 limit 1');
       if ($line = mysqli_fetch_array($result)) {
//$conn_id = ftp_connect($ftp_server);
//$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

//if ((!$conn_id) || (!$login_result)) {
 //      echo "FTP connection has failed!";
 //      echo "Attempted to connect to $ftp_server for user: $ftp_user_name";
  //     exit;
   //} else {
   //    echo "Connected to $ftp_server, for user: $ftp_user_name";
  // }
 //  $filep='C:\shanghai\1.jpg';
  // if (@ftp_chdir($conn_id, "public_html/mail/$iddancefile/$zakazId")) {
 //   echo "Новая текущая директория: " . ftp_pwd($conn_id) . "\n";
//} else { 
 //   echo "Не удалось сменить директорию\n";
//}
//@ftp_mkdir($conn_id, "public_html/mail/$iddancefile/$zakazId");
  // if (ftp_mkdir($conn_id, 'public_html/2')) {
 //echo "Создана директория \n";
//} else {
// echo "Не удалось создать директорию $dir\n";
//}
//   $upload = ftp_put($conn_id, "public_html/mail/$iddancefile/$zakazId/".$line['name'], $path_to_folder[0].'/'.$line['name'], FTP_BINARY);
// проверяем статус загрузки
//if (!$upload) {
  //     echo "Error: FTP upload has failed!";
  // } else {
    //   echo "Good: Uploaded ".$path_to_folder[0].'/'.$line['name'].'<br>';
  // }
   	
	//ftp_close($conn_id);
	
       	
$post_var=array();
 $post_var['id_news']=$iddancefile;

  $post_var['id_order']=$zakazId;

  $post_var['id_foto']=$line['name'].'.jpg';
  $post_var['foto_file']= base64_encode(file_get_contents($path_to_folder.'/'.$line['name']));			
  $post = http_build_query($post_var);
  $options = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded
         User-Agent: Mozilla/3.9',
        'content' => $post
     )
    );
  $context = stream_context_create($options);
    $result = file_get_contents('http://mail.dancefile.eu/sendmail.php?foto', false, $context);
  if ($result==md5_file($path_to_folder.'/'.$line['name'])) {; 
  	$mysqli->query('UPDATE `dancefile`.`foto` SET `sendedmail` = "1" WHERE `foto`.`id` = '.$line['id']);
  	echo 'ADD Order# '.$post_var['id_order'].', foto  '.$post_var['id_foto'].'<br>';
  } else {echo $result.'Ошибка передачи фото!';};	

	
	   }else {
	   	
	//	$conn_id = ftp_connect($ftp_server);
//$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

//if ((!$conn_id) || (!$login_result)) {
 //      echo "FTP connection has failed!";
 //      echo "Attempted to connect to $ftp_server for user: $ftp_user_name";
  //     exit;
  // } else {
   //    echo "Connected to $ftp_server, for user: $ftp_user_name";
  // }
 //  $filep='C:\shanghai\1.jpg';
  // if (@ftp_chdir($conn_id, "public_html/mail/$iddancefile/$zakazId")) {
 //   echo "Новая текущая директория: " . ftp_pwd($conn_id) . "\n";
//} else { 
 //   echo "Не удалось сменить директорию\n";
//}
//@ftp_mkdir($conn_id, "public_html/mail/$iddancefile/$zakazId");
  // if (ftp_mkdir($conn_id, 'public_html/2')) {
 //echo "Создана директория \n";
//} else {
// echo "Не удалось создать директорию $dir\n";
//}
   
   	
	
		$file_folder = $path_to_folder.'/'; // папка с файлами
		 $dir=$file_folder.'cd/';
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
if( $file == '.' || $file == '..' || is_dir($dir.$file)) continue;
//$upload = ftp_put($conn_id, "public_html/mail/$iddancefile/$zakazId/".$file, $dir.$file, FTP_BINARY);
// проверяем статус загрузки
//if (!$upload) {
//       echo "Error: FTP upload has failed!";
  // } else {
    //   echo "Good: Uploaded ".$file.'<br>';
  // }			
			
$post_var=array();
$post_var['id_news']=$iddancefile;
$post_var['id_order']=$zakazId;
$post_var['id_foto']=$file;
$post_var['foto_file']= base64_encode(file_get_contents($dir.$file));			
$post = http_build_query($post_var);
$options = array('http' =>
array(
'method'  => 'POST',
'header'  => 'Content-type: application/x-www-form-urlencoded
 User-Agent: Mozilla/3.9',
'content' => $post
    )
    );
  $context = stream_context_create($options);
    $result = file_get_contents('http://mail.dancefile.eu/sendmail.php?foto', false, $context);
  echo $result; 
 
  }}}
//ftp_close($conn_id);

$post_var=array();
$post_var['id_news']=$iddancefile;
$post_var['id_order']=$zakazId;
$post_var['mail']=$mail;
$post = http_build_query($post_var);
$options = array('http' =>
array(
'method'  => 'POST',
'header'  => 'Content-type: application/x-www-form-urlencoded
 User-Agent: Mozilla/3.9',
'content' => $post
    )
    );
  $context = stream_context_create($options);

	$result = file_get_contents('http://mail.dancefile.eu/sendmail.php?mail', false, $context);
	echo $result;
	$mysqli->query('UPDATE `dancefile`.`zakaz` SET `mailStatus` = "2" WHERE `zakaz`.`id` =  '.$zakazId);	
 	
	   };  };
	 

?>
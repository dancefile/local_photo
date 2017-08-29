<?php 
$item_name='Order #6293';
echo substr($item_name,7);
//if (substr($item_name,0,7)=='Order #') echo 'ok';
exit;
$current='';
$file = 'a.txt';
  foreach ($_POST as $key => $value) {
    $current .= "$key=$value;";
  }
  
$current .= "\r\n";

$f =fopen($file,"a");

fwrite($f, $current);

fclose($f);




?>
transaction_subject=;
payment_date=16:15:00 May 31, 2017 PDT;
txn_type=web_accept;
last_name=Cloke;
residence_country=GB;
item_name=Order #6293;
payment_gross=;
mc_currency=EUR;
business=info@dancefile.eu;
payment_type=instant;
protection_eligibility=Eligible;
verify_sign=AH1pol-O9H-rvd9mM0ld1W1mHNV0A4Id3Qgfp5xJOIgVpeIt2GL2YPgy;
payer_status=unverified;
tax=0.00;
payer_email=tomcloke56@googlemail.com;
txn_id=68L749884S7119404;
quantity=1;
receiver_email=info@dancefile.eu;
first_name=Tom;
payer_id=Y2XP4XZP25VWQ;
receiver_id=8WP58SC6P7KXA;
item_number=1;
payment_status=Completed;
payment_fee=;mc_fee=0.74;
shipping=0.00;
mc_gross=11.54;
custom=;
charset=windows-1252;
notify_version=3.8;
ipn_track_id=a3c6ffd069c1a;

if (isset($_POST['item_name']) && substr($_POST['item_name'],0,7)=='Order #')

$mysqli->query('UPDATE `order` SET `status_pay` = 3, `sum`="'.$_POST['orderSumAmount'].'", `currency`="RUB" WHERE `id_o`='.$_POST['orderNumber'].' LIMIT 1');
if ($rs12  = $mysqli->query('SELECT * FROM `order_photo` where `id_o`='.$_POST['orderNumber'].' and `status`=0'))
if ($line12 = mysqli_fetch_array($rs12))
{}
else {

$email = $_POST['customerNumber'];
$headers  = "Content-type: text/html; charset=utf-8\r\n"; 
$headers .= "From: DanceFile <info@dancefile.ru>\r\n"; 
$subject = "Заказ фотографий на сайте DanceFile.ru"; 
$body ='<html>  
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">  
</head> 
<body>  
Здравствуйте!<br/>Спасибо за оплату Вашего заказ!<br/>
Скачать фотографии можно из <a href="http://www.dancefile.ru/account.php?a=searchorder&id='.$_POST['orderNumber'].'" >личного кабинета</a> на нашем сайте или по ссылкам:<br/><br>';
	if ($rs12  = $mysqli->query('SELECT * FROM `order_photo` where `id_o`='.$_POST['orderNumber']))
while ($line12 = mysqli_fetch_array($rs12)) {
	$body .='<a href="http://www.dancefile.ru/download.php?id='.$line12['id'].'&pas='.$line12['id_c'].'">'.$line12['name'].'</a><br>';
};

$body .='
<br/><br/>
С уважением, коллектив проекта DanceFile.ru.<br/>
info@dancefile.ru<br/>
+7 967 149-04-39<br/>
</body>  
</html>';
//mail($email, $subject, $body, $headers);
require_once "../SendMailSmtpClass.php"; 
$mailSMTP = new SendMailSmtpClass('info@dancefile.ru', 'DanceFile1122', 'ssl://smtp.yandex.ru', 'info', 465);
$result =  $mailSMTP->send($email, $subject, $body, $headers);
}
/*
namespace Listener;

require('PaypalIPN.php');

use PaypalIPN;

$ipn = new PaypalIPN();

// Use the sandbox endpoint during testing.
$ipn->useSandbox();
$verified = $ipn->verifyIPN();
if ($verified) {
	
$f =fopen('avisook.txt',"a");

fwrite($f, $current);

fclose($f);
	
    /*
     * Process IPN
     * A list of variables is available here:
     * https://developer.paypal.com/webapps/developer/docs/classic/ipn/integration-guide/IPNandPDTVariables/
     */
//}

// Reply with an empty 200 response to indicate to paypal the IPN was received correctly.
header("HTTP/1.1 200 OK");

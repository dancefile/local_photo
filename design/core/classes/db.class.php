<?php

mysql_connect($db['host'],$db['user'],$db['password']) OR DIE("�� ���� ������� ���������� ");
mysql_select_db($db['name']) or die(mysql_error());

$path_to_folder = array();
$n = array();
$query = "SELECT * FROM settings where kkey='path_to_folder' or kkey='n'";

$result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());

while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
    switch ($line['kkey']) {
        case "path_to_folder":
            $path_to_folder[]=iconv("UTF-8","Windows-1251",$line['value']);
        break;
        case "n":
            $n[] = $line['value'];
        break;
    }
    
}

?>
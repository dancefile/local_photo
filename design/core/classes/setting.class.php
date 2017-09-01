<?php
class setting{
    public function get($key){
        $query = "SELECT * FROM settings where kkey='$key'";
        $result = mysql_query($query);
        return mysql_fetch_array($result, MYSQL_ASSOC)['value'];
    }
}
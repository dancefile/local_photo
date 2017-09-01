<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Report base creating class
 * Data type: json
 * Separator: \r\n
 * Version of the script: 1.0.5
 * Author: mr.Slink
 *
 * Script description:
 * This script converts MySQL database into Json format
 * and stores it on the server (in the panel). The file is free
 * read without losing speed, and recover data
 * turning the file into a full database with the possibility
 * editing of data (orders).
 *
 * @package Report
 */
 /*
    How to use this:

    //# GENERATE FILE REPORT #
    //Declare a class:
    $report = new Report();

    //Specify the parameters:
    $report->$archive_path        = "./archiv/";
    $report->$atc_enable          = false;
    $report->$encrypt_enable      = false;
    $report->$cleardb_enable      = false;
    $report->$cleardb_ignore      = ['settings', 'pass']; 

    //Run the process of generating a file:
    $report->write();

    //# READ FILE REPORT #
    //Declare a class:
    $report = new Report();

    //Run the process of generating a file:
    $array = $report->read("filename.db", 1); //Where 1 is the number of the table
    foreach($array as $i){..}
*/
Class Report{

    Public $archive_path        = "./archiv/";          //Path to the archive folder
    Public $atc_enable          = false;                //Automatic thumbnail creation enable
    Public $encrypt_enable      = false;                //File encryption enable
    Public $cleardb_enable      = false;                //Clear database enable
    Public $cleardb_ignore      = ['settings', 'pass']; //Clear database ignore table

    Public Function __construct(){
        session_start();
        if(!$_SESSION['auth'])
        {
            header("Location: ./admin_auth.php");
            die();
        }
    }
    
    /**
     * Function to clear database
     *
     * @return string
     */
    Public Function cleardb(){
        if($this->cleardb_enable == true){
            $result = mysql_list_tables("dancefile");

            while ($table = mysql_fetch_row($result)) {
                if(!in_array($table[0], $this->cleardb_ignore)){
                    mysql_query("TRUNCATE TABLE ".$table[0]);
                }  
            }
            return true;
        }
        return false;
    }

    /**
     * Function to get the path to the archive
     *
     * @return string
     */
    Public Function path(){
        return $this->archive_path;
    }

    /**
     * Function to get the path to the archive
     *
     * @return boolean
     */
    Public Function atc(){
        return $this->atc_enable; 
    }

    /**
     * Function to get the path to the archive
     *
     * @return boolean
     */
    Public Function encrypt(){
        return $this->encrypt_enable;
    }

    /**
     * Function of reading the database file.
     *
     * @param string    $filename   Base file name
     * @param integer   $part       File reading part
     *
     * @return array    data in an asynchronous array
     */
    Public Function read($filename, $part){
        if (file_exists($this->path().$filename)){
            $FileOpen = fopen($this->path().$filename,"r");
            $FileRead = fread($FileOpen, filesize($this->path().$filename));

            fclose($FileOpen);
            return $this->decryption(json_decode(explode("\r\n", $FileRead)[$part], true));
        }
        return false;
    }

    /**
     * Function for reading the settings in the database file.
     *
     * @param string    $filename   Base file name
     * @param string    $key        Settings key
     *
     * @return string   Value key
     */
    Public Function read_setting($filename, $key){
        $JsonSetting = $this->read($filename, 3);
        foreach($JsonSetting as $index){
            if($index['kkey'] == $key){
                return $index['value'];
            }
        }
        return false;
    }

    /**
     * Saving thumbnails of photos
     *
     * @param array    $array  mysql_query
     *
     * @return string
     */
    Public Function thumbnail_creation($array){
        $rows = array();$i=0;
        while($r = mysql_fetch_assoc($array)) {
            $i++;
            $rows[$i]['id'] = $r['id'];
            $rows[$i]['name'] = $r['name'];
            $rows[$i]['base64'] = $this->to_base64("./ph/".$r['url']."/".$r['name']);
        }
        return json_encode($rows);
    }

    /**
     * Convert image to base64
     *
     * @param array    $array  mysql_query
     *
     * @return string
     */
    Private Function to_base64($path){
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    /**
     * File Encryption
     *
     * @param string    $content
     *
     * @return string   Encrypted string
     */
    Private Function encryption($content){
        if($this->encrypt() == true){
            return base64_encode($content);
        }
        return $content;
    }

    /**
     * File Encryption
     *
     * @param string    $content
     *
     * @return string   Decrypted string
     */
    Private Function decryption($content){
        if($this->encrypt() == true){
            return base64_decode($content);
        }
        return $content;
    }

    /**
     * Function of recording the database file
     *
     * @return boolean
     */
    Public Function write(){
        require_once "db.php";

        $result = mysql_list_tables("dancefile"); $Content="";

        while ($table = mysql_fetch_row($result)) {$Content .= $this->to_json(mysql_query("SELECT * from ".$table[0]))."\r\n";};

        if($this->atc() == true){
            $Content .= $this->thumbnail_creation(mysql_query("SELECT * from foto"));};

        $FileOpen = fopen($this->path().date("d").rand(1000,9999).date("m").".db","w");

        fwrite($FileOpen, $Content);
        fclose($FileOpen);

        $this->cleardb();
        return $Content;
    }

    /**
     * Function of converting a sql table into a json format.
     *
     * @param array    $array  mysql_query
     *
     * @return string
     */
    Private Function to_json($array){
        $rows = array();
        while($r = mysql_fetch_assoc($array)) {
            $rows[] = $r;
        }
        return $this->encryption(json_encode($rows));
    }
}
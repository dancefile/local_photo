<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Report base creating class
 * Data type: json
 * Separator: \r\n
 * Version of the script: 1.0.7
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
    include("db.php);
    $report->archive_path        = "./archiv/";
    $report->atc_enable          = false;
    $report->encrypt_enable      = false;
    $report->cleardb_enable      = false;
    $report->cleardb_ignore      = ['settings', 'pass']; 
    $report->db_name             = $dbName;

    //Run the process of generating a file:
    $report->write();

    //# READ FILE REPORT #
    //Declare a class:
    $report = new Report();

    //Run the process of generating a file:
    $array = $report->read("filename.db", "zakaz"); //Where "zakaz" is name of the table
    foreach($array as $i){..}

    //# RESTORE DB TO FILE REPORT #
    //Declare a class:
    $report = new Report();

    //Run the process of generating a file:
    $report->$cleardb_enable = true;    //Enable clear database mode
    $restore->cleardb();                //Clear database now
    $array = $report->restore("filename.db");   //Restore database
*/
Class Report{

    Public $archive_path        = "./archiv/";          //Path to the archive folder
    Public $atc_enable          = true;                 //Automatic thumbnail creation enable
    Public $encrypt_enable      = false;                //File encryption enable
    Public $cleardb_enable      = false;                //Clear database enable
    Public $cleardb_ignore      = ['settings', 'pass']; //Clear database ignore table
    Public $db_name             = "dancefile";          //Database name
    Public $table_list;                                 //List of the database table

    /*========================================================================*/
    /*                                                                        */
    /*                            Don't edit this:                            */
    /*                                                                        */
    /*========================================================================*/
    
    Public Function __construct(){
         $result = mysql_list_tables($this->db_name);

        while ($table = mysql_fetch_row($result)) {
            $this->table_list[] = $table[0];
        }
        $this->table_list[] = "thumbnail";
    }
    
    /**
     * Function to clear database
     *
     * @return string
     */
    Public Function cleardb(){
        if($this->cleardb_enable == true){
            $result = mysql_list_tables($this->db_name);

            while ($table = mysql_fetch_row($result)) {
                if(!in_array($table[0], $this->cleardb_ignore)){
                    mysql_query("TRUNCATE TABLE ".$table[0]);
                }  
            }
            return true;
        }
        return false;
    }

    Public Function report_exists($filename){
       return file_exists($this->archive_path.$filename);
    }

    public function restore($filename){
        foreach($this->table_list as $table){
            if($table != "thumbnail"){
                $tablex = $this->read($filename, $table);
                foreach($tablex as $key){
                    $name = implode("`, `",array_keys($key));
                    $value = implode("', '",$key);
                    mysql_query("INSERT INTO `".$table."` (`".$name."`) VALUES ('".$value."')");
                }
            }
        }
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
            if(!is_integer($part)){
                if(in_array($part, $this->table_list)){
                    $part = array_search($part, $this->table_list);
                } else {
                    return false;
                }
            }
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
        $JsonSetting = $this->read($filename, "settings");
        foreach($JsonSetting as $index){
            if($index['kkey'] == $key){
                return $index['value'];
            }
        }
        return false;
    }

    /**
     * Function for reading the creation date file.
     *
     * @param string    $filename   Base file name
     *
     * @return string   Date
     */
    Public Function create_date($filename){
        return date("d.m.Y", filectime($this->archive_path.$filename));
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
     * Saving thumbnails of photos
     *
     * @param array    $array  mysql_query
     *
     * @return string
     */
    Public Function thumbnail_read($filename, $imgname){
        foreach($this->read($filename, array_search("thumbnail", $this->table_list)) as $index){
            if($index['name'] == $imgname){
                return $index['base64'];
            }
        }   
        return false;
    }

    /**
     * Convert image to base64
     *
     * @param path    $array  mysql_query
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
        $result = mysql_list_tables($this->db_name); $Content="";
        while ($table = mysql_fetch_row($result)) {$Content .= $this->to_json(mysql_query("SELECT * from ".$table[0]))."\r\n";};
        if($this->atc() == true){$Content .= $this->thumbnail_creation(mysql_query("SELECT * from foto"));};
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
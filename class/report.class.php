<?php
/**
 * Класс создания базы отчетов
 * Тип данных: json
 * Разделитель: \r\n
 * Версия скрипта: 1.0.8 beta
 * Автор: mr.Slink
 *
 * Описание скрипта:
 * Этот скрипт преобразует базу данных MySQLi в формат Json 
 * и сохраняет ее на сервере (в панели). Файл можно свободно 
 * просматривать без потери скорости и восстанавливать данные.
 *
 * @package Report
 */
 /*
    Как это использовать:
        //# СОЗДАНИЕ ФАЙЛА ОТЧЁТА #
            //Объявите класс:

            $report = new Report();

            //Укажите параметры:
            include("db.php);
            $report->archive_path        = "./archiv/";
            $report->atc_enable          = false;
            $report->encrypt_enable      = false;
            $report->cleardb_enable      = false;
            $report->use_mysqli          = true;
            $report->cleardb_ignore      = ['settings', 'pass']; 
            $report->db_name             = $dbName;

            //Запустите процесс создания файла:
            $report->write();

        //# ЧТЕНИЕ ФАЙЛА ОТЧЁТА #
            //Объявите класс:
            $report = new Report();

            //Запустите процесс чтения файла в массив:
            $array = $report->read("filename.db", "zakaz"); //Where "zakaz" is name of the table
            foreach($array as $i){..}
        
        //# ВОССТАНОВЛЕНИЕ БАЗЫ ИЗ ОТЧЁТА #
            //Объявите класс:
            $report = new Report();
            
            //Запустите процесс чтения файла:
            $report->cleardb_enable = true;             //Включите функцию очистки базы
            $restore->cleardb();                        //Запустите ее
            $array = $report->restore("filename.db");   //Восстановите базу
        
        Чистка - не обязательный процесс, но может вызвать ошибку, если информация в базе присуствует.
    */
Class Report{
    //Параметры по-умолчанию
    Public $archive_path        = "./archiv/";          //Путь к папке архива
    Public $atc_enable          = true;                 //Автоматическое создание эскизов
    Public $encrypt_enable      = false;                //Шифрование файлов
    Public $cleardb_enable      = false;                //Фкнция очистки базы
    Public $cleardb_ignore      = ['pass','settings']; //Таблицы, которые будут проигнорированы при очистки
    Public $db_name             = "dancefile";          //Имя текущей базы
    /*
    * Код:
    */
    //Список таблиц текущей базы
    Public $table_list; 
    
    Public Function __construct(){
global $mysqli;
            $result = mysqli_query($mysqli, "SHOW TABLES");
            while($table = mysqli_fetch_array($result)){
                $this->table_list[] = $table[0];
            }
        
        $this->table_list[] = "thumbnail";
    }
    
    /**
     * Функция очистки базы данных
     *
     * @return string
     */
    Public Function cleardb(){
    	global $mysqli;
        if($this->cleardb_enable == true){
			mysqli_query($mysqli,'DELETE FROM `dancefile`.`settings` WHERE `kkey`="path_to_folder" or `kkey`="md5";');
			mysqli_query($mysqli,'INSERT INTO `dancefile`.`settings` (`kkey`, `value`) VALUES ("path_to_folder","C:/"),("md5","'.md5(time().gethostname()).'");');
                $result = mysqli_query($mysqli, "SHOW TABLES");
                while ($table = mysqli_fetch_array($result)) {
                        if(!in_array($table[0], $this->cleardb_ignore)){
                        mysqli_query($mysqli, "TRUNCATE TABLE ".$table[0]);
                    }  
                }
                return true;
            }
        
        return false;
    }
    /**
     * Проверка существования файла
     *
     * @return boolean
     */
    Public Function report_exists($filename){
       return file_exists($this->archive_path.$filename);
    }
    /**
     * Функция восстановления базы данных
     */
    public function restore($filename){
    	global $mysqli;
        foreach($this->table_list as $table){
            if($table != "thumbnail"){
                $tablex = $this->read($filename, $table);
				unset($tablex[0]);
				//var_dump($tablex); echo '<br><br>';
				 foreach($tablex as $key){
				// 	var_dump($key);echo '<br><br><br>';
                    $name = implode("`, `",array_keys($key));
					$value='';
					foreach($key as $key2) {
						
						if ($key2===null) $value.= 'null,'; else $value.='"'.$key2.'",';;
					}
					$value=substr($value, 0,-1);
                    mysqli_query($mysqli, 'INSERT INTO `'.$table.'` (`'.$name.'`) VALUES ('.$value.')');
                }
            }
        }
    }
    /**
     * Получаем путь к архиву
     *
     * @return string
     */
    Public Function path(){
        return $this->archive_path;
    }
    /**
     * Получаем разрешение на создание эскизов
     *
     * @return boolean
     */
    Public Function atc(){
        return $this->atc_enable; 
    }
    /**
     * Получаем разрешение на шифрование файлов
     *
     * @return boolean
     */
    Public Function encrypt(){
        return $this->encrypt_enable;
    }
    /**
     * Функция чтения файла отчёта
     *
     * @param string    $filename   Имя файла базы
     * @param integer   $part       Имя или номер таблицы
     *
     * @return array    данные в асинхронном массиве
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
			//if ($part=='9') var_dump(json_decode(explode("\r\n", $FileRead)[$part], true));
			
			//if ($part=='9') var_dump(json_decode(explode("\r\n", $FileRead)[$part], true));
			//exit;
			//echo $part.' ';
            return $this->decryption(json_decode(explode("\r\n", $FileRead)[$part], true));
        }
        return false;
    }
    /**
     * Функция чтения настроек из файла отчёта (из таблицы Settings)
     *
     * @param string    $filename   Имя файла базы
     * @param string    $key        Ключ
     *
     * @return string   Значение
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
     * Генерация имени файла из текущей даты
     *
     * @param string    $filename   Base file name
     *
     * @return string   Date
     */
    Public Function create_date($filename){
        return date("d.m.Y", filectime($this->archive_path.$filename));
    }
    /**
     * Сохранение эскизов в формате json
     *
     * @param array    $array  mysql_query
     *
     * @return string json
     */
    Public Function thumbnail_creation($array){
        $rows = array();$i=0;

            while($r = mysqli_fetch_assoc($array)) 
            {
                $i++;
                $rows[$i]['id'] = $r['id'];
                $rows[$i]['base64'] = $this->to_base64("./ps/".$r['id'].'.jpg');
            }
        
        return json_encode($rows);
    }
    /**
     * Получение кода эскиза из файла по ID фотографии
     *
     * @param string    $filename   Имя файла базы
     * @param string    $imgname    ID фотографии
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
     * Конвертирование изображения в base64
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
     * Шифрование файла
     *
     * @param string    $content
     *
     * @return string   Зашифрованная строка
     */
    Private Function encryption($content){
        if($this->encrypt() == true){
            return base64_encode($content);
        }
        return $content;
    }
    /**
     * Дешифрование файла
     *
     * @param string    $content
     *
     * @return string   Дешифрованная строка
     */
    Private Function decryption($content){
        if($this->encrypt() == true){
            return base64_decode($content);
        }
        return $content;
    }
    /**
     * Функция записи файла отчёта
     *
     * @return boolean
     */
    Public Function write(){
global $mysqli;
  ///      require_once "db.php";


            $result =  mysqli_query($mysqli, "SHOW TABLES");
        
        
        $Content="";

            while ($table = mysqli_fetch_row($result)) {
                $Content .= $this->to_json(mysqli_query($mysqli, "SELECT * from ".$table[0]),$table[0])."\r\n";
            };
        
        
                $Content .= $this->thumbnail_creation(mysqli_query($mysqli, "SELECT * from fotos"));    
        
        
        $FileOpen = fopen($this->path().date("d").rand(1000,9999).date("m").".db","w");
        fwrite($FileOpen, $Content);
        fclose($FileOpen);
        $this->cleardb();
        return $Content;
    }
    /**
     * Функция конвертирования данных в формат json
     *
     * @param array    $array  mysql_query
     *
     * @return string
     */
    Private Function to_json($array,$tableName){
    	
        $rows = array();
$rows[]=$tableName; 

            while($r = mysqli_fetch_assoc($array)) {
                $rows[] = $r;
            }
        
        return $this->encryption(json_encode($rows));
    }
}

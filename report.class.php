<?php
/**
 * Класс создания базы отчетов
 * Тип данных: json
 * Разделитель: \r\n
 * Версия скрипта: 1.0.7
 * Автор: mr.Slink
 *
 * Описание скрипта:
 * Этот скрипт преобразует базу данных MySQL в формат Json 
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
    Public $cleardb_ignore      = ['settings', 'pass']; //Таблицы, которые будут проигнорированы при очистки
    Public $db_name             = "dancefile";          //Имя текущей базы

    /*
    * Код:
    */
    //Список таблиц текущей базы
    Public $table_list; 
    
    Public Function __construct(){
         $result = mysql_list_tables($this->db_name);

        while ($table = mysql_fetch_row($result)) {
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
        while($r = mysql_fetch_assoc($array)) {
            $i++;
            $rows[$i]['id'] = $r['id'];
            $rows[$i]['name'] = $r['name'];
            $rows[$i]['base64'] = $this->to_base64("./ph/".$r['url']."/".$r['name']);
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
     * Функция конвертирования данных в формат json
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

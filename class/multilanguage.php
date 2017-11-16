<?php
/*
 * 	class Multilanguage
 *  Класс для вывода слов на нужном языке
 * 	Версия: 1.2
 *  Автор: Совместные усилия
 * 
 * 	Пример использования:
 *   	$langarray['susl']=array('Суслик','Gopher'); //масив слов
 * 		$newlanguage= new Multilanguage($langarray); //передаёт массив слов конструктору 
 * 		$newlanguage->setLang(1); //задаётся код языка, сохраняется в $_session['lang'] 
 *		echo $newlanguage->susl; //выводит слово по коду 'Gopher'
 */
		class Multilanguage
			{
				 
				public $lang = 0;//текущий язык
				private $words=array();
	       		public function setLang($lang=0) 
					{
						$_SESSION['mlang']=$lang;
			    		$this->lang = $lang;
					} 
				public function __get( $word)	
					{
						 if (isset ($this->words[$word][$this->lang]))
							$word= $this->words[$word][$this->lang];
						  return $word;
					}
				public function __construct($array)
					{
						if(isset($_SESSION['mlang']))
						$this->lang=$_SESSION['mlang'];
						else $this->lang = 0;
						$this->words=$array; 	
					} 
			}

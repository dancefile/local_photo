<?php
$lang='en';
if (isset($_SESSION['lang'])) {
	$lang=$_SESSION['lang'];
}
else{
if (($list = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']))) {
            if (preg_match_all('/([a-z]{1,8}(?:-[a-z]{1,8})?)(?:;q=([0-9.]+))?/', $list, $list)) {
                $language = array_combine($list[1], $list[2]);
                foreach ($language as $n => $v)
                    $language[$n] = $v ? $v : 1;
                arsort($language, SORT_NUMERIC);
            }
        } else $language = array();
//$load_lang=1;

foreach ($language as $key => $value) {
	switch ($key) {
    case "ru":
       $lang='ru';
        break 2;
    case "en":
       $lang='en';
        break 2;
    case "de":
       $lang='de';
        break 2;
	case "zh":
       $lang='zh';
        break 2;
	case "cs":
       $lang='cs';
        break 2;
		
	};
};
$_SESSION['lang']=$lang;
};

			
define ('brendname','DanceFile.'.$domen);
define ('url','info@dancefile.'.$domen);
define ('mainpage','DanceFile');

switch ($lang) {
case "ru":
define ('fotografer','Фотограф');
define ('fotos',' фотографий:');	
define ('moving',' перемещаются...');
define ('move','переместить');
define ('ShoppingCart','Корзина');//Shopping Cart
define ('ALREADYincart','Эта фотография в корзине');//This photo is ALREADY in your cart.
define ('Addphoto','Положить фото к корзину');//Add this photo to the cart
define ('allonCD','Все фото в цифровом формате');//Put all photos on CD
define ('comment','Ком.');//
define ('price','Стоимость: ');//
define ('digital','Файл (CD,e-mail...)');//

define ('orderready','Спасибо! Ваш заказ сохранен.');//Please ask our manager for assistance.
define ('ordernamber','Номер Вашего заказа: ');//'Your Order # '
define ('total','Сумма');//Total
define ('page','Страницы');//Main page
define ('back','Назад');//Back

define ('pricekor','Кор.&nbspцены');//
define ('deletephoto','Убрать из корзины');//Delete this photo
define ('photos','Количество фото в заказе: ');//photos
define ('Makeorder',' Оформить заказ ');// Make order 
define ('Paid','Оплачен');//Paid
define ('CleanCart','Удалить все фото из корзины');//Clean your Cart
define ('cartempty','Корзина пуста');//The cart is empty
define ('Search','Поиск по номерам фотографий');//Search
define ('Picturesinyourcart','В корзине');//Pictures in your cart
define ('Go','Искать');//Go
define ('folderempty','В этой папке еще нет фото :(');//This folder is empty
define ('photoaddedcart','Фотография добавлена в корзину');//This photo is added to your cart
define ('Thanks','Спасибо!');

define ('order','Заказ №');
define ('Your_price','Цена');

define ('use_','Используйте');
define ('to_download_your_fotos_at','чтобы загрузить свои фото на');
define ('Thank_you','Спасибо!');

define ('next_page','следующая страница');

//Используйте info@dancefile.ru, чтобы загрузить свои фото на dancefile.eu/mail

//Use info@dancefile.ru to download your fotos at dancefile.eu/mail


break ;
 
case "de":
define ('fotografer','Fotograf');
define ('price','Стоимость: ');//
define ('orderready','Vielen Dank! Ihre Bestellung ist erfasst.');
define ('ordernamber','Ihre Auftragsnummer: ');
define ('total','Summe');
define ('page','Seiten');
define ('back','zurueck');
define ('ShoppingCart','Warenkorb');
define ('allonCD','Markiere alle Fotos als digitale Kopien');
define ('comment','Anm.');
define ('pricekor','Preiskorrekt.');
define ('deletephoto','Aus Warenkorb entfernen');
define ('photos','Fotos im Auftrag: ');
define ('Makeorder',' Bestellung absenden ');
define ('Paid','Bezahlt');
define ('CleanCart','Alle Fotos aus Warenkorb entfernen');
define ('cartempty','Warenkorb ist leer');
define ('Search','Bilder nach Nummern suchen');
define ('Picturesinyourcart','Im Warenkorb');
define ('Go','Suche');//Go
define ('folderempty','Dieser Ordner enthaelt noch keine Fotos :(');
define ('photoaddedcart','Foto in Warenkorb gelegt');
define ('ALREADYincart','Dieses Foto ist bereits im Warenkorb');
define ('Addphoto','Foto in Warenkorb legen');
define ('Thanks','Vielen Dank!');
define ('digital','Digitální (CD, e-mail ...)');
define ('order','Bestell-Nr.');
define ('Your_price','Preis');
define ('Thank_you','Vielen Dank!');
define ('next_page','Nächste Seite');

break ;


case "zh":
define ('fotografer','攝影師');
define ('price','成本: ');//
define ('orderready','请向我们的经理寻求帮助');	 
define ('ordernamber','你的订单 ＃ ');
define ('total','总');
define ('back','背部');
define ('ShoppingCart','购物车');
define ('allonCD','將所有照片標記為數字副本');
define ('comment','评论');
define ('pricekor','Price cor.');
define ('deletephoto','删除照片');
define ('photos','文件总量 ');
define ('Makeorder',' 下单 ');
define ('Paid','支付');
define ('CleanCart','清理你的车');
define ('cartempty','车是空的');
define ('Search','输入您的照片编号');
define ('Picturesinyourcart','您的购物车图片');
define ('Go','搜索');
define ('folderempty','这个文件夹是空的');
define ('photoaddedcart','这张照片被添加到您的购物车');
define ('ALREADYincart','这张照片已经在你的车');
define ('Addphoto','将此照片添加到购物车');
define ('page','页');//Main page
define ('Thanks','谢谢');
define ('digital','數字（CD 電子郵件...）');
define ('order','订单号');
define ('Your_price','價格');
define ('Thank_you','謝謝');
define ('next_page','下一頁');
break ;

case "cs":
define ('fotografer','Fotograf');
define ('price','Náklady: ');//
define ('orderready','Děkujeme! Vaše objednávka byla přijata ke zpracování');
define ('ordernamber','č. vaší objednávky: ');
define ('total','K zaplacení');
define ('page','Stránky');
define ('back','Zpět');
define ('ShoppingCart','Nákupní koš');
define ('allonCD','Označte všechny fotografie jako digitální kopie');
define ('comment','komentář');
define ('pricekor','Upravit cenu');
define ('deletephoto','Smazat fotografii');
define ('photos','Počet objednaných fotografií: ');
define ('Makeorder','Objednat'); 
define ('Paid','Zaplaceno');
define ('CleanCart','Odstranit všechny fotografie z nákupního koše');
define ('cartempty','Nákupní koš je prázdný');
define ('Search','Hledat fotografie podle čísla');
define ('Picturesinyourcart','Fotografie v nákupním koši');
define ('Go','Hledat');
define ('folderempty','Složka je zatím prázdná :(');
define ('photoaddedcart','Fotografie byla přidána do nákupního koše');
define ('ALREADYincart','Fotografie je již v nákupním koši');
define ('Addphoto','Přidat do nákupního koše');
define ('Thanks','Děkujeme!');	
define ('digital','Digitální (CD,e-mail...)');//
define ('order','Objednací číslo');
define ('Your_price','Cena');
define ('Thank_you','Děkuji!');
define ('next_page','Na další stránce');
break ;

default:
define ('fotografer','Photographer');
define ('price','Price: ');//
define ('orderready','Thank you very much!'); 
define ('ordernamber','Your Order # ');
define ('total','Total');
define ('back','Back');
define ('ShoppingCart','Your Cart');
define ('allonCD','Mark all photos as digital copies');
define ('comment','Comment');
define ('pricekor','Price cor.');
define ('deletephoto','Delete this photo');
define ('photos','Total quantity of files: ');
define ('Makeorder',' Make order ');
define ('Paid','Paid');
define ('CleanCart','Clean your Cart');
define ('cartempty','The cart is empty');
define ('Search','Type in numbers of your photographs');
define ('Picturesinyourcart','Pictures in your cart');
define ('Go','Search');
define ('folderempty','This folder is empty');
define ('photoaddedcart','This photo is added to your cart');
define ('ALREADYincart','This photo is ALREADY in your cart.');
define ('Addphoto','Add this photo to the cart');
define ('page','Page');//Main page
define ('Thanks','Thanks!');
define ('digital','Digital (CD,e-mail...)');//
define ('order','Order No.');
define ('Your_price','Your price');
define ('use_','Use');
define ('to_download_your_fotos_at','to download your fotos at');
define ('Thank_you','Thank you!');
define ('next_page','Next page');

};
?>

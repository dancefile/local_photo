<?php
            function url_link($str,$flag,$d_n) {
                if ($str<>'') {
                    $string=url_link(substr($str,0,strrpos($str,'/')),1,$d_n);
                    if ($flag) {
                        $string.=' | <a href="?url='.urlencode($str).'&d='.$d_n.'">'.iconv("Windows-1251","UTF-8", substr($str,strrpos($str,'/')+1)).'</a>';
                    } else {
                        $string.=' | '.iconv("Windows-1251","UTF-8",substr($str,strrpos($str,'/')+1));
                    }
                } else {
                    $string='';
                }
                return $string;
	        }
        ?>
<body>
    <!-- head start -->
    <header>
        <nav class="navbar navbar-one navbar-default navbar-fixed navbar-fixed-top">
            <div class="container"><div class="col-md-12">
                <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand text-center" style="padding-top: 5px;" href="index.html">DanceFile.ru</br><small>www.dancefile.ru</small></a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Главная</a></li>
                    <li><a href="javascript:open_window('price')">Наши цены</a></li>
                    <li class="hidden-sm sm-hidden"><a href="javascript:open_window('calendars')">Рамки и календари</a></li>
                    <li class="hidden-sm sm-hidden"><a class="btn btn-default" style="padding: 6px;margin-top: 9px;" href="javascript:open_window('live')">Трансляция <i class="glyphicon glyphicon-record"></i></a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                         <a href="?p=basket" class="btn btn-link" style="color: white;margin:-7px;">Корзина <span id="countfoto" class="btn btn-default"><?php if(isset($_SESSION['name'])){ echo count($_SESSION['name']); } else { echo "0"; } ?></span></a>
                    </li>
                    <li>
                        <form action="search.php" style="padding: 8px; height: 35px;" method="get">
                                <input class="form-control" list="fotki" name="serach" id="serach"  placeholder="Поиск фотографий" type="text" value="<? if (isset($_GET['serach'])){echo $_GET['serach'];}; ?>"> 
                                <input type="submit" class="hidden" value="Поиск" onClick="submit(); this.disabled = true; " >
                        </form>
                    </li>
                    <?php $login = isset($_SESSION['login'])? $_SESSION['login']:"Вход"; ?>
                    <li>
                    <a class="hidden-sm sm-hidden hidden-xs xs-hidden" href="admin.php"><i class="glyphicon glyphicon-user"></i> <?=$login?></a>
                    </li>
                </ul>
                    </div>
                </div><!--/.nav-collapse -->
            </div><!--/.container-fluid -->
        </nav>
        <nav class="navbar-two">
            <div class="container">
                <ol class="breadcrumb col-md-10 col-sm-10 col-xs-10">
                    <li><a href="?p=main">Главная</a></li>
                    <?php 
                        if(isset($_GET['url'])){
                            $get_line = iconv("Windows-1251","UTF-8",$_GET['url']); 
                            $url = explode('/',$get_line);
                            $i=0; 
                            $count = count($url); 
                            foreach ($url as $value) { 
                                $i++;
                                if($i == $count){$active='active';}
                                if($i >= 2){?>
                                    <?php
                                        $x = 0;
                                        $urlx = array();
                                        while ($x <= $i-1) {
                                            $urlx[$x] = $url[$x++];
                                        }

                                        $urla = urlencode(iconv("UTF-8","Windows-1251",implode("/",$urlx)));
                                    ?>
                                    <li class="<?=$active?>"><a href="?p=gallery&d=0&url=<?=$urla?>"><?=$value?></a></li>
                                <? } ?> 
                            <? } ?>
                    <? } ?>
                </ol>
                <div class="col-md-2 col-sm-2 col-xs-2 text-right">
                    <a id="close" href="javascript:close_window('window_name')" class="btn btn-default hidden" style="color: white">Закрыть X</a>
                </div>
            </div>
        </nav>
    </header>
    <!-- head end -->
<?php theme::load("head"); ?>
<?php theme::load("header"); ?>
    <div id="content" class="content"> 

    <!-- body start -->
    <div class="container">
        <?
            foreach ($path_to_folder as $key => $value) {
                
                if (is_dir($path_to_folder[$key])){
                    $dh = opendir( $path_to_folder[$key]) or die ( $d[$key] );
                    while ( $f = readdir( $dh ) ) {
                        if ('.'<>$f & '..'<>$f &  $f<>'trash'&  $f<>'NO') {
                            if (is_dir($path_to_folder[$key].'/'.$f)) {?>
                                <a href="?p=gallery&d=<?=$key?>&url=<?=urlencode('/'.$f)?>" class="folder panel col-md-2">
                                    <div class="name">
                                        <?=iconv("Windows-1251","UTF-8", $f)?>
                                    </div>
                                </a>
                           <? }
                        }
                    }
                }
            };
        ?>
    </div>
    <!-- body end -->
</div>
<?php theme::load("photo"); ?>
<?php theme::load("price"); ?>
<?php theme::load("calendars"); ?>
<?php theme::load("live"); ?>
<?php theme::load("footer"); ?>
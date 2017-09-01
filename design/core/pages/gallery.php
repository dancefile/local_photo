<?php theme::load("head"); ?>
<?php theme::load("header"); ?>
    <div id="content" class="content"> 
        <!-- body start -->
        <div class="container">
        <?php
            $cuont=0;
            $url=url_link($u,0,$d_n);
            $u1=str_replace("'","''",$u);
            $basketName=array();
            $refresh=false;
            $id_url=0;

            $query = 'SELECT id,date FROM url where d='.$d_n.' and url=\''.iconv("Windows-1251","UTF-8",$u1).'\' limit 1;';
            $rs = mysql_query($query) or die( mysql_error());
            
            if ($line = mysql_fetch_array($rs, MYSQL_ASSOC)) {
                $id_url=$line["id"]; 
                if ($line["date"]<>date ("Y-m-d H:i:s", filemtime($path_to_folder[$d_n].$u)) ) {
                    $rs=mysql_query("DELETE FROM fotos where url=$id_url;");
                    $refresh=true;
                };
            } else {
                $sql='INSERT INTO url (d,url) Values ('.$d_n.',\''.iconv("Windows-1251","UTF-8",$u1).'\');';
                $rs=mysql_query($sql);
                $rs=mysql_query('SELECT @@Identity AS NewValue FROM url');
                if ($line = mysql_fetch_array($rs, MYSQL_ASSOC)) 
                $id_url =$line["NewValue"];
                $refresh=true;
            }

            if ($refresh) {
                $query = 'UPDATE  url SET date=\''.date ("Y-m-d H:i:s", filemtime($path_to_folder[$d_n].$u)).'\' where id='.$id_url;
                $rs=mysql_query($query);
                $dh = opendir( $path_to_folder[$d_n].$u) or die ( "$path_to_folder[$d_n].$u" );
                $sql2='';
                $urls=array();
                while ( $f = readdir( $dh ) ) {
                    if (strripos($f,'.jpg')){
                        $tmp=substr($f,0,strripos($f,'.jpg'));
                        if ($tmp!='') {
                            $urls[]=substr($f,0,strripos($f,'.jpg'));
                        }
                        $sql2.='('.$id_url.',\''.substr($f,0,strripos($f,'.jpg')).'\',\''.date ("Y-m-d H:i:s", filemtime($path_to_folder[$d_n].$u.'/'.$f)).'\'),';
                    }
                }
                $rs=mysql_unbuffered_query('INSERT INTO `fotos` (`url`,`name`,`date`) Values '.substr($sql2,0,-3).';');
            }


            if (isset($_SESSION['name']) and count($_SESSION['name'])>0) {
                foreach ($_SESSION['name'] as $i => $value) {
                    if ($_SESSION['url'][$i]==$id_url) {
                        $basketName[]=$value;
                    }
                }
            }

            $q="SELECT count(*) FROM fotos where url='$id_url'";
            $res=mysql_query($q);
            $row=mysql_fetch_row($res);
            $total_rows=$row[0]; 	
            $page_str='';

            $dh = opendir( $path_to_folder[$d_n].$u ) or die ( "error1" );
            while ( $f = readdir( $dh ) ) {
                if ('.'<>$f & '..'<>$f &  $f<>'trash'&  $f<>'NO') {
                    if (is_dir($path_to_folder[$d_n].$u.'/'.$f)) { ?>
                        <a href="?p=gallery&d=<?=$d_n?>&url=<?=urlencode($u.'/'.$f)?>" class="folder panel col-md-2">
                            <div class="name">
                                <?=iconv("Windows-1251","UTF-8", $f)?>
                            </div>
                        </a>
                    <?php
                    $cuont++;
                    };
                }
            }

            $sql = 'SELECT name,url FROM fotos where url='.$id_url.' order by date,name;';
            $rs2 = mysql_query($sql) or die( mysql_error());
            echo '<div class="col-md-12" id="vl-img">';
            while ($line = mysql_fetch_array($rs2, MYSQL_ASSOC)) {
                $name=$line['name'];
                echo '<div class="folder col-md-2">';
                if (in_array($name,$basketName)) {
                    $fancybox=' style="border: 1px solid #00bb00;" ';$vl=1;} else {$vl=0;$fancybox='';
                }
                $cuont++;

                if ($_SERVER['HTTP_HOST'] == "localhost:777") {
                    echo '<a href="http://vaio1:777/img.php?url='.$line['url'].'&name='.urlencode ( $name).'" ';
                } else {
                    echo '<a href="http://vaio1:777/pb/'.$line['url'].'/'.$name.'.jpg" ';
                }
                echo ' class="fancybox" rel="group" vl="'.$vl.'"  title="'.$name.'" oncontextmenu="add_basket(this, \''.$name.'\');"><img class="lazy" data-src="http://vaio1:777/ph/'.$line['url'].'/'.$name.'.jpg" src="./assets/img/foto.jpg"'.$fancybox.'></a>';
                ?>
                <div class="name">
                <?=iconv("Windows-1251","UTF-8", $name)?>
                </div></div>
                <?php
            }
            
            echo "</div>";

            if ($cuont==0) {echo '<br>'.folderempty.'<br>';}; 
        ?>
        </div>
        <!-- body end -->
    </div>
</body>
<?php theme::load("price"); ?>
<?php theme::load("calendars"); ?>
<?php theme::load("live"); ?>
<?php theme::load("photo"); ?>
<?php theme::load("footer"); ?>
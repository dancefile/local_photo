<?php 
if(isset($_GET['key'])){
    if($_GET['key'] == "price"){
        if($_GET['op'] == "a6"){
            echo setting::get("price10");
        }
        if($_GET['op'] == "a5"){
            echo setting::get("price15");
        }
        if($_GET['op'] == "a4"){
            echo setting::get("price20");
        }
        if($_GET['op'] == "cd"){
            echo setting::get("pricecd");
        }  
        if($_GET['op'] == "sk"){
            echo setting::get("cdsile");
        }      
    }
    if($_GET['key'] == "addRight"){
        if (isset($_GET['del'])){
            foreach ($_SESSION['name'] as $i => $value) {
                if ($value==$_GET["name"] && $_SESSION['url'][$i]==$_GET["url"]) {
                    unset($_SESSION['name'][$i]);
                    unset($_SESSION['url'][$i]);
                    unset($_SESSION['cd'][$i]);
                    unset($_SESSION['a6'][$i]);
                    unset($_SESSION['a5'][$i]);
                    unset($_SESSION['a4'][$i]);
                    unset($_SESSION['comm'][$i]);
                    unset($_SESSION['korprice'][$i]);
                };
            };
        } else {
            $_SESSION['name'][]=$_GET["name"];
            $_SESSION['url'][]=$_GET["url"];
            $_SESSION['cd'][]=0;
            $_SESSION['a6'][]=0;
            $_SESSION['a5'][]=0;
            $_SESSION['a4'][]=0;
            $_SESSION['comm'][]='';
            $_SESSION['korprice'][]=0;
            $query='INSERT INTO `baskets` (`url`,`name`,`ip`,`data`)  Values ('.$_GET["url"].',\''.$_GET["name"].'\','.substr($_SERVER['REMOTE_ADDR'],strripos($_SERVER['REMOTE_ADDR'],'.')+1).',now());';
            $result = mysql_query($query) or die( mysql_error());
        };
    }
}
<?php
session_start();
$classes = scandir("./core/classes/");foreach($classes as $class){if($class !== "." and $class !== ".."and !is_dir("./core/classes/".$class)){include("./core/classes/".$class);}}
$library = scandir("./core/library/");foreach($library as $lib){if($lib !== "." and $lib !== ".." and !is_dir("./core/library/".$lib)){include("./core/library/".$lib);}}
if(isset($_GET['p']) and file_exists("./core/pages/".$_GET['p'].".php")){
    $u = isset($_GET['url']) ? $_GET['url']:"";
    $d_n = isset($_GET['d']) ? $_GET['d']:0;
    include("./core/pages/".$_GET['p'].".php");
} else {
    include("./core/pages/main.php");
}
$theme = new theme;
?>
<?php
if(isset($_GET['key'])){
    include("core/api/".$_GET['key'].".php");
}
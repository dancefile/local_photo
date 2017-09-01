<?php
function genQR($link){
    include("./core/library/google.qr.lib/core.php");
    $qr = new qrcode();
    $qr->link($link);
    echo "<div style='opacity:0.5;width:250px;height:250px;background-image:url(./core/library/google.qr.lib/dancefile.ru.png);background-size: 100% 100%;' border='0'/>";
}
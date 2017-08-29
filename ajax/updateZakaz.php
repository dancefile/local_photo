<?php
session_start();
if(!$_SESSION['auth'])
{
    header("Location: ./admin_auth.php");
    die();
}
?>

<?php
    $zid = $_GET['zid'];
    $ok = $_GET['ok'];
    $oplata= $_GET['oplata'];
include "../db.php";
$mysqli->query("UPDATE zakaz SET ok=$ok , oplata=$oplata where id=$zid");
echo "sucess";
?>
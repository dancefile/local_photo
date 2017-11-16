<?php
session_start();
if(!$_SESSION['auth'])
{
    header("Location: ./admin_auth.php");
    die();
}
?>
<?php
$zakazId = $_GET['zid'];

$recover = $_GET['recover'];
include "../db.php";
$mysqli->query("UPDATE  zakaz SET del=$recover where id=$zakazId");
echo "succes";
?>
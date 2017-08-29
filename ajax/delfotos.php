<? 
include ('../db.php');
if (isset($_GET['ids'])) {

$in=substr(str_replace('.jpg', '', $_GET['ids']),1);
//echo 'UPDATE `fotos` SET `url`=-1 WHERE `id` IN ('.$in.')';
$mysqli->query('UPDATE `fotos` SET `url`=-1 WHERE `id` IN ('.$in.')');
//echo 'UPDATE `fotos` SET `url`=-1 WHERE `id` IN ('.$in.')'; 
}
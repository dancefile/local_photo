

<?php
include_once "db.php";
function getDownPhoto()
{global $mysqli;
    $a = array();
if ($rs = $mysqli->query('select * from down_photo'))
    while ($line = mysqli_fetch_array($rs))
    {
        $a[$line['photo_id']]=true;
    }
    return $a;
}

?>
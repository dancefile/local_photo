<?	
include ('../db.php');
include('../lang.php');
function SearchImg($dir)
{ global $imgCount;
if (is_dir($dir)) if ($dh=opendir($dir))
{while ($f=readdir($dh)) {
	if ($imgCount>4999) break;
if ('.'<>$f & '..'<>$f &  $f<>'trash'&  $f<>'NO') {
if (is_dir(rtrim($dir,'/\\').'/'.$f)) SearchImg(rtrim($dir,'/\\').'/'.$f); else if (strripos($f,'.jpg')){
	//echo $f.'<br>';
$imgCount++;

}}}}}

if ($rs = $mysqli->query('SELECT * FROM `flash` ORDER BY `flash`.`url` ASC'))
 while ($line = mysqli_fetch_array($rs)) {
$imgCount=0;
echo '<br><div>'.$line['url'].fotos; 		
SearchImg($line['url']);
echo '<span id="fotos'.$line['id'].'">'.$imgCount.'</span>';
//if ($line['time']) {
//$timeFlash = strtotime($line['time']);
//$timeFlash=time()-$timeFlash; 
//if ($timeFlash>300) {
	///добавить перезапуск скачки
//}}
$fotografer='';
$list = scandir($line['url']);
 foreach($list as $item)
 {
   $item_l = strtolower($item) ;
    if ($item != "." and $item != "..") {
        if (strpos($item_l,".txt")){
         
           $fotografer=substr($item, 0,-4);
           break;
        }
    }
 
}
if ($line['toId']) {echo moving;} else if ($imgCount) echo ' <span id="dir'.$line['id'].'" fotog="'.$fotografer.'" class="link flash" id="move'.$line['id'].'">'.move.'</span>';

echo '<br>'.$fotografer;
 
echo '</div>';
} 
?>	
<?php
session_start();
if(!$_SESSION['auth'])
{
    header("Location: ./admin_auth.php");
    die();
}
include ("db.php");
include 'lang.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <script src="/js/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/admin.css" media="screen" />
    <title></title>
    <script>
        var zakazId =<?php echo $_GET['id'];?>;
        var idsfotos = [];
        var showDeleted = <?php
            if(isset($_GET['showDeleted'])){
                echo 1;
            }else
                echo 0;
        ?>;
            function addToMyBasket(id){
        $.get("ajax/addOrderToMyBasket.php?bid="+id);
    } 
        function changeColor(id1){
            document.getElementById("a_"+id1)
                .setAttribute("style","color:orange");
        }
      
            function tomail(id){
            	
var mail = document.getElementById("mail").value;

var id = <? echo $_GET['id'];?>;
$.get( "ajax/toMail.php", { mail: mail,id:id} )
 .done(function( data ) {
 $("#mailStatus").html(data);
    
      });
      
    }; 
   function print_chek (order){
   	$.get( "ajax/print_chek.php", {order:order} )
 .done(function( data ) {

      });

   	}  
        function recalc(id){
        setTimeout(function() {
            
            var a6 = document.getElementById("a6_"+id).value;
            var a5 = document.getElementById("a5_"+id).value;
            var a4 = document.getElementById("a4_"+id).value;
            //var cd = document.getElementById("cd_"+id).value==null? 0:1;
            var cd = $("#cd_"+id+":checked").val()==null ? 0 : 1;
            var korprice= document.getElementById("korprice_"+id).value;
          //  alert(korprice);
            var coment = document.getElementById("coment_"+id).value;
        //    var price = parseInt(document.getElementById("price_"+id).innerHTML);
            
            $.get( "ajax/savePhoto.php", { pid: id,a6:a6,a5:a5,a4:a4,cd:cd,korprice:korprice,coment:coment,zid:zakazId } )
                .done(function( data ) {
                	//alert(data);
                data  = jQuery.parseJSON(data );
                $("#total").text(data['total']);
                  jQuery.each(data['foto'], function(i, val) {
      $("#price_"+i).text(val);
     });

                });


         }, 0);       
        }
        
        function moveAllPhoto(){
            var retVal = prompt("Enter new id zakaza : ");
            if(retVal==null){
                return;
            }
            var newZakazId = parseInt(retVal);
            $.get( "moveAllPhoto.php", {oldZakazID: zakazId,
                newZakazID:newZakazId } )
                .done(function( data ) {
                    if(data.indexOf("error")!=-1)
                        alert("error!");
                    else {
                        
                        if(ZakazId!=zakazId)
                            deleteRow(id);
                    }
                });
        }
        function saveZakaz()
        {
            var payd=0;
            if($("#cpayd1:checked").val()!=null) {payd=1};
            if($("#cpayd2:checked").val()!=null) {payd=2};
            if($("#cpayd3:checked").val()!=null) {payd=3};
            var ready = $("#cready1:checked").val()==null ? 0 : 1;
            $.get( "ajax/updateZakaz.php", {zid: zakazId,
                ok:ready,oplata:payd } )
                .done(function( data ) {//window.close();
                    /*if(data.indexOf("error")!=-1)
                        alert("error!");
                    else {
                        alert("Saved!");
                    }*/
                });
        }
        function deleteRow(photoID){
            $("#tr_"+photoID).remove();
        }
        function copyPhoto(id){
            var retVal = prompt("Enter id zakaza : ");
            if(retVal==null){
                retrun;
            }
            var ZakazId_n = parseInt(retVal);
            if(ZakazId_n!=zakazId) {
           // alert(zakazId);
            $.get( "movePhoto.php", {pid: id,zid:zakazId,zidn:ZakazId_n} )
                .done(function( data ) {
               // alert (data);
                    if(data.indexOf("error")!=-1)
                        alert("error!");
                    else {
                    
                     data  = jQuery.parseJSON(data );
                $("#total").text(data['total']);
                  jQuery.each(data['foto'], function(i, val) {
      $("#price_"+i).text(val);
     });
                        
                            deleteRow(id);
                    }
                });
        }}
        function deletePhoto(id){
            var recover = 0;
            if(showDeleted==0){
                recover = 1;
            }
           
            $.get( "deletePhoto.php", { photoId: id,recover:recover,zid: zakazId } )
                .done(function( data ) {

                    if(data.indexOf("error")!=-1)
                        alert("error!");
                    else {
                                        data  = jQuery.parseJSON(data );
                $("#total").text(data['total']);
                  jQuery.each(data['foto'], function(i, val) {
      $("#price_"+i).text(val);
     });

                        deleteRow(id);
                    }
                });
        }
        function downloadPhoto(id){
            window.location = "downloadPhoto.php?photoId="+id;
        }
        function plus_minusval(field,addval,id){
            //alert(field+"   "+addval+"  "+id);
            $("#a"+field+"_"+id).val( $("#a"+field+"_"+id).val()*1+addval);
            recalc(id);
        }


       
 //idsfotos
                    

    </script>

</head>
<body>
	<h3>
<input type="button" value="Закрыть окно" onClick="window.close();">
</h3><br>
<h1 align="center">Zakaz #: <?php echo $_GET['id']?></h1>
<h3>
    <?php
    $id = $_GET['id'];
    if(isset($_GET['showDeleted'])){
        echo "<a href='./edit.php?id=$id'>Show not deleted</a>";
    }else
        echo "<a href='./edit.php?id=$id&showDeleted'>Show Deleted</a>";

    ?>
</h3><br>
<h2>
    <table  align="center" border="3">
        <tr align="center">
            <th>Main Operations</th>
            <th>Ready</th>
            <th>Payment</th>
            <th>Total</th>
            <th>Other Operations</th>

        </tr>
        <tbody>
<?
$result = $mysqli->query('SELECT * FROM `zakaz` WHERE `id` = '.$_GET['id']);
if ($line = mysqli_fetch_array($result))
{
                   	?>
            <tr>
                <td>
                    
                    <a href="zip.php?zid=<?php echo $_GET['id'];?>&command=cd"
                       download="<?php echo $_GET['id'];?>"> Download files</a><br><br>
                       <button onclick="print_chek(<?php echo $_GET['id'];?>)">Print receipt</button>
                  <br><br>
                   <div id="mailStatus">
                   	<?
                   	switch ($line['mailStatus']) {
						   case '1':  echo 'Uploading to the server';  break;
						   case '2':  echo 'Sent';  break;
					   }
                   	echo '<br><input type="text"  id="mail" size="40" placeholder="e-mail" value="'.$line['mail'].'"><br>';
                    echo' <button onclick="tomail()">to mail</button>';
					if ($line['mailStatus']==1) 
                   	?>
                   </div>
                </td>
                <td id="tcready" onclick="saveZakaz();">
<? echo '<input type="checkbox" id="cready1" ';
if ($line['ok']) echo 'checked';
echo ' class="checkbox">'; ?>
                </td>
                <td id="tcpayd">
<? echo '<input type="checkbox" id="cpayd1" '; if ($line['oplata']==1) echo 'checked';echo ' class="checkbox paycheck">Сash<br>'; ?>
<? echo '<input type="checkbox" id="cpayd2" '; if ($line['oplata']==2) echo 'checked';echo ' class="checkbox paycheck">Transfer<br>'; ?>
<? echo '<input type="checkbox" id="cpayd3" '; if ($line['oplata']==3) echo 'checked';echo ' class="checkbox paycheck">Other<br>'; ?>
                </td>
                  <td id="total">
<? echo $line['summa'];?>
                </td>
<td>
<a href="zip.php?zid=<?php echo $_GET['id'];?>&command=all"
                       download="<?php echo $_GET['id'];?>"> Download All</a><br><br>
                        <a href="./admin.php" onclick="moveAllPhoto()">All photo to other zakaz</a><br><br>
                       <button onclick='addToMyBasket(<?php echo $_GET['id'];?>)'>Add to my Basktet</button>
</td>
            </tr>
            

            <? } ?>
            
        </tbody>
    </table>


    <table id="tbl1" align="center" border="3">
        <tr align="center">
            <th>Photo</th>
            <th> </th>
            <th>Korprice</th>
            <th>Coment</th>
            <th>Price</th>
            <th>Operations</th>
        </tr>
                    <?
if(isset($_GET['showDeleted'])) $deleted=1; else $deleted=0;


    $a = array();
    $result = $mysqli->query('select * from down_photo');
    while ($line = mysqli_fetch_array($result))
    {
        $a[$line['photo_id']]=true;
    }
$style1="style='background-color: black; color: white;' ";

 $result = $mysqli->query('SELECT * from foto where zakaz='.$_GET['id'].' and del='.$deleted);
while ($line = mysqli_fetch_array($result)) {      
echo '<tr id=\'tr_'.$line['id'].'\' align="center">
 <td><a href="./pm/'.$line['name'].'.jpg" rel="example_group"   title="'.$line['name'].'"><img src="./ps/'.$line['name'].'.jpg" hspace="5" vspace="5"></a></td>
 <td>File <input type=\'checkbox\' id=\'cd_'.$line['id'].'\' onchange=\'recalc('.$line['id'].')\''; 
 if ($line['cd']) echo ' checked ';
 echo ' class=\'checkbox\'><br><br>
A6 <input type="text"  id="a6_'.$line['id'].'" ';
if ($line['a6']) echo $style1; 
echo ' onchange="recalc('.$line['id'].')" onkeydown="recalc('.$line['id'].')" value ="'.$line['a6'].'" oncontextmenu="plus_minusval(6,-1,'.$line['id'].')" onclick="plus_minusval(6,1,'.$line['id'].')" size="2"></input><br><br>
A5 <input type="text"  id="a5_'.$line['id'].'" ';
if ($line['a5']) echo $style1; 
echo ' onchange="recalc('.$line['id'].')" onkeydown="recalc('.$line['id'].')" value ="'.$line['a5'].'" oncontextmenu="plus_minusval(5,-1,'.$line['id'].')" onclick="plus_minusval(5,1,'.$line['id'].')" size="2"></input><br><br>
A4 <input type="text"  id="a4_'.$line['id'].'" ';
if ($line['a4']) echo $style1; 
echo ' onchange="recalc('.$line['id'].')" onkeydown="recalc('.$line['id'].')" value ="'.$line['a4'].'" oncontextmenu="plus_minusval(4,-1,'.$line['id'].')" onclick="plus_minusval(4,1,'.$line['id'].')" size="2"></input><br><br>
</td><td><input type="text"  id="korprice_'.$line['id'].'" onchange="recalc('.$line['id'].')" onkeydown="recalc('.$line['id'].')" value ="'.$line['korprice'].'" size="2"></input></td>
<td><input type="text"  id="coment_'.$line['id'].'" ';
if ($line['coment']) echo $style1; 
echo ' onchange="recalc('.$line['id'].')" onkeydown="recalc('.$line['id'].')" value ="'.$line['coment'].'"></input></td>
<td><p id="price_'.$line['id'].'">'.$line['price'].'</p></td>
<td><a id="a_'.$line['id'].'" href="downloadPhoto.php?photoId='.$line['id'].'" style="color:';
if(isset($a[$line['id']])) echo "orange"; else echo "blue";
echo '" onclick="changeColor('.$line['id'].')">Download</a><br><br><br>
<button onclick="deletePhoto('.$line['id'].')">';
if ($line['del']) echo "Recover"; else echo "Delete";
echo '</button><br><button onclick="copyPhoto('.$line['id'].')">Move photo</button>
</td></tr>';
            
            }
            
            ?>

    </table>
</h2>

    <input type="button" value="Закрыть окно" onClick="window.close();">
<br><br>
</body>
 <script type="text/javascript">
$("body").on("contextmenu", false);
$( document ).ready(function() {
	
	$('.paycheck').change(function(){
		var check=false;
	if(this.checked){check=true;};	
$('.paycheck').prop('checked', false);
if (check) {$(this).prop('checked', 'checked');};
saveZakaz();
//return false;
});
	
	});
</SCRIPT>
</html>
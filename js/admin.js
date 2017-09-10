var lastIdMove=0;
var IdDir='dir1';
var fotog='';



  function sendMail()
        {
        	
$("#sendMail").html('wait');
            $.ajax({ url: "ajax/sendMail.php",
                timeout: 60000 }).done(
                function (result, status) {
                	
                    result = result.trim();
                    if (result.length >0){
                            $("#sendMail").html(status+'<br>'+result);
                       setTimeout(sendMail, 500);

                    } else { $("#sendMail").html(status+'<br><button onclick="sendMail()">Send mail</button>');}
                });
        }
       
       
       
       
                               function makeCache()
        {
        	if (!$("#makeCache button").prop("disabled")) {
        	$("#makeCache button").prop("disabled",true);

            $.ajax({ url: "ajax/makeCache.php",
                timeout: 25000 }).done(
                function (result, status) {
                    result = result.trim();
                    if (result.length >0){
                            $("#makeCache").html(result);
                       setTimeout(makeCache, 100);

                    } else { $("#makeCache").html(status+'<br><button onclick="makeCache()">Make Cache</button>');}
                });
        }}
       
       
        function updateTable(payd,ready,enable)
        {

            $.ajax({ url: "ajax/getAllZakaz.php?deleted="+showDeleted+
                "&payd="+payd+"&ready="+ready+"&showAll="+!enable,
                timeout: 8000 }).done(
                function (result, status) {
                	//alert(result);
                    result = result.trim();
                    if (result.length >0){
                        result = jQuery.parseJSON(result);
                        var tbody = $("#tbody");
                        tbody.children().remove();
                        for (var index = 0; index < result.length; index++) {
                            var operation = result[index];
                            //alert(operation);
                            var id = operation.id;
                            tbody.append(
                                "<tr id='tr_"+id+"' align=\"center\">" +
                                "<td><a href='edit.php?id="+operation.id+"'  target=\"_blank\"> " + (operation.id || "") + " </a></td>" +
                                "<td>" + (operation.summa || "") + "</td>" +
                                "<td>" + (operation.oplata || "") + "</td>" +
                                "<td>" + (operation.ok || "") + "</td>" +
                                "<td>" + (operation.data || "") + "</td>" +
                                "<td>" + (operation.menedger || "") + "</td>" +
                                "<td><button onclick='deleteZakaz("+operation.id+")'>"+(showDeleted==1?"Recover":"Delete")+"</a><br>"
                                + "</td>" +

                                "</tr>");
                        }
                    }
                });
        }
        
                function checkChange(){
            var payd = $("#cpayd:checked").val()==null ? 0 : 1;
            var ready = $("#cready:checked").val()==null ? 0 : 1;
            var enabled = $("#cenable:checked").val()==null ? 0 : 1;

            updateTable(payd,ready,enabled);
        }



function renewflash(){ //вывод информации по флешкам
	$.get( "ajax/renewflash.php" )
    .done(function( data ) {
     if(data.indexOf("error")!=-1)
      alert("error!");
     else {
     $("#flash").html(data);
}});}


function underflash(){ //
 $.get("ajax/underflash.php")
  .success(function(data) {
  	var time=20000;
  	//alert(data);
  	data = data.trim();
    if (data.length >0){
    	data = jQuery.parseJSON(data);
    if (data.time) {time=data.time;};
  if (data.str!== undefined) { $("#under").html(data.str);
  if (data.str==-1) renewflash();
  } else {$("#under").html("Ошибка выполнения");};
   
    }
    setTimeout(underflash,time);
  	
  	})
  .error(function() {setTimeout(underflash,1000); $("#under").html("Ошибка выполнения"); });


}


function winMoveFlash(lastId,x,y){ //вывод окна для перемешения фоток с флешки
var params = {lastId:lastId,fotog:fotog};
//alert (lastId);
//alert (fotog);
$.ajax({
type: "POST",
url: "ajax/moveFotos.php",
data: params,
success: function(data){
	if (x!=0) {
	$("#move_wrapper").html(data).show();
	$('#move_wrapper').offset({top:y, left:x});
	} else {$("#move_wrapper").html(data);}
}});	
}	



 function report()
        {
        	
            $.ajax({ url: "ajax/report.php",
                timeout: 60000 }).done(
                function (result, status) {
                   result = result.trim();
$("#dreport").append(status+': '+result+'<br>');
                    if (result.length >0){
                    	
                            
                      setTimeout(report, 500);

                    };
                });
        }


$( document ).ready(function() {
	
$('#report').click(function(){	

if (confirm('Вы уверены, что хотите закрыть конкурс?')) {$("#dreport").html("");
report();

};
});
	
	
	
	
	
	
$('html').click(function(){
	$('#move_wrapper').hide();
});


$('#move_wrapper').click(function(){
return false;
});



$('#flash').on('click','.flash',function(){//нажатие на ссылку переместить
	loc=$(this).offset();
	IdDir=$(this).attr('id');
	fotog=$(this).attr('fotog');
	winMoveFlash(lastIdMove,loc.left,loc.top)
	return false;	
});

$('#move_wrapper').on('click','.flash',function(){
lastIdMove=$(this).attr('id');
winMoveFlash($(this).attr('id'),0,0)
	return false;	
});

$('#move_wrapper').on('click','.link_i',function(){
	$('#move_wrapper').hide();
	$('#'+IdDir).text("перемешаются")
	.removeClass("link flash");
var params = {IdDir:IdDir,IdUrl:$(this).attr('id'),photografer:$('#photografer').val()};
$.ajax({
type: "POST",
url: "ajax/StartMoveFotos.php",
data: params,
success: function(data){
//	alert (data);
underflash();
}});	
	

});


$('#move_wrapper').on('keypress','#addkat', function (e) {
         if(e.which === 13){
$(this).attr("disabled", "disabled");
	$.get( "ajax/newKat.php?per="+$(this).attr('per')+"&val="+$(this).val() )
    .done(function( data ) {
//var params = {IdDir:IdDir,IdUrl:data};
//$.ajax({
//type: "POST",
//url: "ajax/StartMoveFotos.php",
//data: params,
//success: function(data){
//alert(data);
winMoveFlash(data,0,0)
//}});
   	
    	

            //Enable the textbox again if needed.
          //  $(this).removeAttr("disabled");
         
   });
   }
   
  });
renewflash();
underflash();
setInterval(makeCache,300000);

});
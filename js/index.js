function lang (code)
{
 $.get('ajax/lang_change.php?lang='+code)
  .success(function(data) {
  	location.reload();
  });
}
 

$(document).ready(function() {
$("body").on("contextmenu", false);
$("body").on("selectstart", false);
$("body").on("dblclick", false);
$("body").on("dragstart", false);
$("body").on("click",function() {if(event.button != 0 || event.shiftKey || event.ctrlKey || event.altKey) return false;});

});

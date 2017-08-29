function lang (code)
{
 $.get('ajax/lang_change.php?lang='+code)
  .success(function(data) {
  	location.reload();
  });
}




function price(){
var suum=0;
var	count=0;
$('.photo').each(function(i,elem) {
	count++;
	elemid=$(elem).attr("id").substr(4)
	sum=0;
	if ($('#cd'+elemid).prop( "checked" )) sum=pricecd;
	sum=sum+$('#a6'+elemid).val()*price10;
	sum=sum+$('#a5'+elemid).val()*price15;
	sum=sum+$('#a4'+elemid).val()*price20;
	suum=suum+sum;
	$('#price'+elemid).html(sum);
	//alert($(elem).attr("id").substr(4));
	//if ($(elem).prop("checked")) { $(elem).prop("checked",false); foto_count($(elem));};
});	
$('#total').html(suum);
$('#count').html(count);
};	
	
function nocd(){
$('.cd').each(function(i,elem) {
	if ($(elem).prop("checked")) { $(elem).prop("checked",false); foto_count($(elem));};
});	
price();
};

function cd(){
$('.cd').each(function(i,elem) {
	if (!$(elem).prop("checked")) { $(elem).prop("checked",true); foto_count($(elem));};
});	
price();
};

function minus(name){
var a=$( "#"+ name);
if (a.val()>0) {
a.val(a.val()-1);
foto_count(a);
	price();};
};

function plus(name){
var a=$( "#"+ name);
a.val(a.val()*1+1);
	foto_count(a);
	price();
};



function foto_count(id) {
var a=id.attr("id");
if (id.attr("type")=="checkbox") {
if (id.prop("checked")) {b=1;} else{b=0;};
} else {
var b=id.val();};
var params = {id:a,val:b};

$.ajax({
type: "POST",
url: "ajax/foto_count.php",
data: params,
beforeSend: function(){
document.getElementById(a+"b").innerHTML = "&nbsp;<img src='img/load2.gif'/>&nbsp;";

},
success: function(data){
document.getElementById(a+"b").innerHTML = "&nbsp;<img src='img/load2_emtry.gif'/>&nbsp;";
}});
}

function creatModalWindow (title) {
	
 var e=$('.img');//document.getElementById('vl-img').getElementsByTagName('img');

for(var i=0;i<e.length;i++){ 
  if(e[i].title==title) {var foto=e[i]; break;};
};

if (i>0) {var str=e[i-1].title;$('#left_b').attr('title',str);$('#left_b').show();} else {$('#left_b').hide();}
if (i<e.length-1) {var str=e[i+1].title;$('#right_b').attr('title',str);$('#right_b').show();} else {$('#right_b').hide();}
$('#fancybox-title-over').html(title);
//if ( $(foto).hasClass("img") ) {
//$('#fancybox-title-over').html(title + ' <a href="javascript: add_basket (\''+title+'\');">'+Addphoto+'</a>');
//	            }  else {
//$('#fancybox-title-over').html(title + ' '+ALREADYincart+' <a href="javascript: add_basket (\''+title+'\'); ">'+deletephoto+'</a>');
 //      };
a = Date.now();
$('.curtain').show();
$('.modalWindow').fadeIn('slow');
$('.modalWindow #img_z').attr("src","/pb/"+title);
$('.modalWindow #img_z').hide();
$('.modalWindow #img').attr("src","/pm/"+title);
}


function img() {
	$('.modalWindow').width( window.innerWidth-2 );
	$('.modalWindow').height( window.innerHeight-2 );
	var w_h = $('.modalWindow').height()-100;
	var w_w = $('.modalWindow').width()-200;

	var ratio=1;
	//if (w_h<im_h || w_w<im_w) {
		var ratioh=im_h/w_h;
		var ratiow=im_w/w_w;
		if (ratiow>ratioh) {ratio=ratiow;} else {ratio=ratioh;}
		$('.modalWindow #divimg').height(Math.round(im_h/ratio));
	    $('.modalWindow #divimg').width(Math.round(im_w/ratio));
	    $('.modalWindow #img').height(Math.round(im_h/ratio));
	    $('.modalWindow #img').width(Math.round(im_w/ratio));
	    $('.modalWindow #img_l').height(Math.round(im_h/ratio));
	    $('.modalWindow #img_l').width(Math.round(im_w/ratio));
	//}
}

///////////////////////////////////////////////////////////
$(document).ready(function() {
price();
	
$('.modalWindow #img').load(function(){
var image = new Image();
image.src = $(this).attr("src");
im_h = image.naturalHeight;
im_w = image.naturalWidth;
img();
});	
	
$(window).resize(function() {
if ($('.curtain').is(':visible')) {img();};
});	
	
$('.img').click(function(){

creatModalWindow (this.title)
return false;	
});
	
$( ".count_foto" ).change(function() {
  foto_count( $(this));
  price();
});	
	
	
$('.del').click(function(){
	
var code=$(this).attr("id").substr(3);

 $.get('ajax/del_foto_basket.php?del='+code)
  .success(function() {
  	$('#foto'+code).remove();
  	price();
  });

});	

$('#del').click(function(){
	
$.get('ajax/del_foto_basket.php?all=1')
.success(function() {
$('.photo').remove();
$('#basket').html(cartempty);
});
});	

	
$('.modalWindow #img_z').mouseout(function() {
  $('.modalWindow #img_z').hide();
});

$('#send').click(function(){ 
	$(this).prop('disabled', true);
	var url='';
	if ($('#paid').prop('checked')) {url='&paid=1';};
$.get('ajax/order.php?all=1'+url)
.success(function(data) {
$('#basket').html(data);
});
	return false;	
});

$('.modalWindow #img').click(function(){ // Что будет происходить по клику по ссылке
	zoomEnable=true;
	$('.modalWindow #img_z').show();
	return false;	
});
    		
$('.modalWindow #img_z').click(function(){ // Что будет происходить по клику по ссылке
	zoomEnable=false;
	$('.modalWindow #img_z').hide();
	return false;	
});
    		
$('.modalWindow #img').mouseenter(function(){
	if (zoomEnable) $('.modalWindow #img_z').show();	
});

$('.modalWindow #img_z').mousemove(function(e){
	var offset = $('.modalWindow #divimg').offset();
	var divimg = $('.modalWindow #divimg');
	var img = $('.modalWindow #img_z');
    var X = -1*(((e.pageX - offset.left)/divimg.width())*(img.width()-divimg.width()))+offset.left;
    var Y = -1*(((e.pageY - offset.top)/divimg.height())*(img.height()-divimg.height()))+offset.top;
   img.offset({top:Y.toFixed(), left:X.toFixed()});
});

$('.modalWindow').click(function(event){ //Что будет происходить по клику по форме
	b = Date.now();
	if (b - a>400) {
	 $('.modalWindow #img').removeAttr("width")
       .removeAttr("height")
       .css({ width: "", height: "" })
       .attr("src","images/loading.gif");
		$(this).hide();
    	$('.curtain').hide();};
});
    		
$('#fancybox-title-over').click(function(event){ 
	a = Date.now();
});
  		
$('#right_b').click(function(event){ 
	creatModalWindow (this.title);
	a = Date.now();
	return false;
});

$('#left_b').click(function(event){
	creatModalWindow (this.title); 
    a = Date.now();
    return false;
});
	
$("body").on("contextmenu", false);
$("body").on("selectstart", false);
$("body").on("dblclick", false);
$("body").on("dragstart", false);
$("body").on("click",function() {if(event.button != 0 || event.shiftKey || event.ctrlKey || event.altKey) return false;});

 jQuery("img.lazy").lazy();

});

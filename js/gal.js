var zoomEnable = false;	
var im_w = 1;	
var im_h = 1;
var ratio= 1;
var a = Date.now();
var b = Date.now();
var titlenow='';
var lastId=0;

    if (window.addEventListener) {
      if ('onwheel' in document) {
        // IE9+, FF17+
        window.addEventListener("wheel", onWheel);
      } else if ('onmousewheel' in document) {
        // устаревший вариант события
        window.addEventListener("mousewheel", onWheel);
      } else {
        // Firefox < 17
        window.addEventListener("MozMousePixelScroll", onWheel);
      }
    } else { // IE8-
      window.attachEvent("onmousewheel", onWheel);
    }

    // Это решение предусматривает поддержку IE8-
    function onWheel(e) {
    	if ($('.curtain').is(':visible')) {
      e = e || window.event;

      // deltaY, detail содержат пиксели
      // wheelDelta не дает возможность узнать количество пикселей
      // onwheel || MozMousePixelScroll || onmousewheel
      var delta = e.deltaY || e.detail || e.wheelDelta;
      
     if (delta<0) $('#left_b').trigger('click');
     if (delta>0)  $('#right_b').trigger('click');

      
      e.returnValue = false;
     }
    }

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

 
function img() {

	$('.modalWindow').width( window.innerWidth-2 );
	$('.modalWindow').height( window.innerHeight-2 );
	var w_h = $('.modalWindow').height()-40;
	var w_w = $('.modalWindow').width()-200;


		var ratioh=im_h/w_h;
		var ratiow=im_w/w_w;
		if (ratiow>ratioh) {ratio=ratiow;} else {ratio=ratioh;}
		$('.modalWindow #divimg').height(Math.round(im_h/ratio));
	    $('.modalWindow #divimg').width(Math.round(im_w/ratio));
	    $('.modalWindow #img').height(Math.round(im_h/ratio));
	    $('.modalWindow #img').width(Math.round(im_w/ratio));
	    $('.modalWindow #img_l').height(Math.round(im_h/ratio));
	    $('.modalWindow #img_l').width(Math.round(im_w/ratio));

}


function add_basket (title) {

	$('#fancybox-title-over').html(title);
	$('#photografer-over').html('ups');
	$.get('ajax/add_to_basket.php?name='+title).success(function(data) {
	data = jQuery.parseJSON(data);
	
	$('.vlimg').each(function(index){if ($( this ).attr("title")==title) {foto=$(this);lastclick=index;return ;};});
	

	
    if (data.del) {
    	count_b--;
    $(foto).removeClass('img1').addClass('img');
$('#fancybox-title-over').html(title + ' <a href="javascript: add_basket (\''+title+'\');">'+Addphoto+'</a>');
$('#aa4files').html(count_b);

} else { 
	count_b++;
$(foto).removeClass('img').addClass('img1');
$('#fancybox-title-over').html(title + ' '+ALREADYincart+' <a href="javascript: add_basket (\''+title+'\'); ">'+deletephoto+'</a>');
$('#aa4files').html(count_b);	
}
  });
}

function creatModalWindow (title) {
var i=0;
	zoomEnable=false;
	titlenow=title;
	$('.modalWindow #img_l').removeClass('zoomout');
	$('.vlimg').each(function(index){if ($( this ).attr("title")==title) {foto=$(this);i=index;return ;};});
	
if (i>0) {var str=$('.vlimg').eq(i-1).attr("title");$('#left_b').attr('title',str);$('#left_b').show();} else {$('#left_b').hide();}
if (i<$('.vlimg').length-1) {var str=$('.vlimg').eq(i+1).attr("title");;$('#right_b').attr('title',str);$('#right_b').show();} else {$('#right_b').hide();}
$('#fancybox-title-over').attr('title',title);

var attr = fotograf[foto.attr("ph")];
if ( typeof attr !== 'undefined' && attr !== false) {var str=fotografer+': '+fotograf[foto.attr("ph")]+'.';} else {var str=''};
var attr = foto.attr("data");
if ( typeof attr !== 'undefined' && attr !== false) {var str1=foto.attr("data");} else {var str1=''};
	$('#photografer-over').html(str+' '+str1);
if ( $(foto).hasClass("img") ) {
$('#fancybox-title-over').html(title + ' <a href="javascript: add_basket (\''+title+'\');">'+Addphoto+'</a>');
	            }  else {
$('#fancybox-title-over').html(title + ' '+ALREADYincart+' <a href="javascript: add_basket (\''+title+'\'); ">'+deletephoto+'</a>');
      };
        
a = Date.now();
$('.curtain').show();
$('.modalWindow').fadeIn('slow');

$('.modalWindow #img_z').hide();

$('.modalWindow #img').attr("src","/pm/"+title);

}
//////////////////////////////////////////////
$(document).ready(function() {
price();
	document.body.onkeydown = function(e){


	switch(e.keyCode) {
	case 46://del
	 if ($('#divimg').is(":visible")) if ($('#appst2').is(":visible")){ 
	 	var title=$('#fancybox-title-over').attr('title');
	 	$.get('ajax/delfotos.php?ids=d'+title).success(function(data) {
	 		$(".vlimg[title='"+title+"']").remove();
if ($('#right_b').is(":visible")) {$('#right_b').trigger('click');}
});}
	break;
	
case 32://пробел
case 34:
    case 39:
    case 40:
     if ($('#right_b').is(":visible")) {$('#right_b').trigger('click');
     return false;}
break;	
     case 27: // escape key maps to keycode `27`
  	$('.modalWindow').hide();
	$('.curtain').hide();
	return false;
    break;
    case 33:
    case 37:
    case 38:
     if ($('#left_b').is(":visible")){ $('#left_b').trigger('click');
     return false;}
break;


  }
//Убирает эвент на стрелках, на pageDown, PageUp, Home, End

//if(c>36 && c<41 || c>32 && c<37) return false;

}

window.onscroll = function() {
 // var scrolled = window.pageYOffset || document.documentElement.scrollTop;
 // alert('scrolled');
  //document.getElementById('showScroll').innerHTML = scrolled + 'px';
return false;
}

	
	$('.curtain').click(function(){
	$("#move_wrapper").hide();
	$('.curtain').hide();
	});	

$('#move_wrapper').on('change','.inputAddKat',function(){

	var params = {lastId:lastId,add:$(this).val()};
$.ajax({
type: "POST",
url: "ajax/moveSelectFotos.php",
data: params,
success: function(data){
$("#move_wrapper").html(data).show();
}
});
	});	
$('#move_wrapper').on('click','.link_i',function(){
	
var to=	$( this ).attr("id");
var s='';
if (basket) {s='all'; } else  {$('img.redS').each(function( ) {s=s+','+ $( this ).attr("title")});};
if (s!='') {


var params = {ids:s,to:to};

$.ajax({
type: "POST",
url: "ajax/moveSelPhotos.php",
data: params,
success: function(data){
if (basket) {location.reload();};
$('img.redS').remove();
	$("#move_wrapper").hide();
	$('.curtain').hide();
}
});
}
});		
	
$('#move_wrapper').on('click','.flash',function(){
	lastId=$(this).attr('id');
	var params = {lastId:lastId};
$.ajax({
type: "POST",
url: "ajax/moveSelectFotos.php",
data: params,
success: function(data){
$("#move_wrapper").html(data).show();
}
});
	return false;	
});

$('#delfoto').click(function(){
var s=''
$('img.redS').each(function( ) {s=s+','+ $( this ).attr("title")});
if (s!='') {
$('img.redS').remove();
$.get('ajax/delfotos.php?ids='+s).success(function(data) {

});}
});	

$('#movefoto').click(function(){
	
	var params = {lastId:lastId};
$.ajax({
type: "POST",
url: "ajax/moveSelectFotos.php",
data: params,
success: function(data){
$("#move_wrapper").html(data).show();
$('.curtain').show();
}
});
	
});	
$('#malevich').on("contextmenu", function() {
	 window.location = "/admin.php";

});

$('.vlimg').on("contextmenu", function() {
	
//if (window.var !== undefined) { ... }
if (basket) {return;};	
if ($('#edButon').hasClass('redB')) {
	
	if (lastclick!=-1 && typeof event !=="undefined" && event.shiftKey) {
	var tt=$(this).attr("title");
	var now=0;
$('.vlimg').each(function(index){
	if (tt==$(this).attr("title")) {now=index; //return false;//
		};
});	

var flag_add=$('.vlimg:eq('+lastclick+')').hasClass('redS');
if (now<lastclick) {var vvv=now; now=lastclick; lastclick=vvv};
if (flag_add) {
	$('.vlimg').each(function(index){if (index>=lastclick && index<=now) $(this).addClass('redS');});
} else {$('.vlimg').each(function(index){if (index>=lastclick && index<=now) $(this).removeClass('redS');});};
	
		///////////////////////////////////////////////////////////////////////////////--------------
	} else {
$(this).toggleClass('redS', 'addOrRemove');			
}

var tt=$(this).attr("title");
$('.vlimg').each(function(index){
	if (tt==$(this).attr("title")) {lastclick=index;// return false;
		};
});
		
	} else {
		
if (lastclick!=-1 && typeof event !=="undefined" && event.shiftKey) {		
		
	var tt=$(this).attr("title");
	var now=0;
$('.vlimg').each(function(index){
	if (tt==$(this).attr("title")) {now=index; //return false;//
		};
});	



var str='';
var delstr='';
var flag_add=$('.vlimg:eq('+lastclick+')').hasClass('img1');
if (now<lastclick) {var vvv=now; now=lastclick; lastclick=vvv};
if (flag_add) {
	$('.vlimg').each(function(index){if (index>=lastclick && index<=now) {$(this).removeClass('img').addClass('img1');str=str+';'+$(this).attr("title");}});
} else {$('.vlimg').each(function(index){if (index>=lastclick && index<=now) {$(this).removeClass('img1').addClass('img');delstr=delstr+';'+$(this).attr("title");}});};
	
var params = {basket:str,delbasket:delstr};

$.ajax({
type: "POST",
url: "ajax/add_to_basket.php",
data: params,
success: function(data){
$('#aa4files').html(data);
count_b=data;
}
});
	
} else {add_basket($(this).attr("title"));} 

}
});

$('#edButon').click(function(){
$(this).toggleClass('redB', 'addOrRemove');	
$('#editBs').toggle('display');
});	

$('.pages_enable').click(function(){
var chek=0;
$(this).toggleClass('edit', 'addOrRemove');
if ($(this).hasClass('edit')) {chek=1;};
$.get('ajax/change.php?name=page&value='+chek)
.success(function() {
location.reload();	
});
});	

$('.sort').click(function(){
$.get('ajax/sort.php')
.success(function() {
location.reload();	
});
});	


$('.inputAddKat').change(function(){
 $.get('ajax/editKat.php?add='+this.id.substring(3)+'&name='+$(this).val())
  .success(function() {
location.reload();	
});
});
	
$('.inputLink').change(function(){
 $.get('ajax/editKat.php?id='+this.id.substring(3)+'&name='+$(this).val())
  .success(function(data) {
location.reload();
  });	
	
});	


$('.imLink').click(function(){
var id=this.id;
var flag=id.substring(0,3);
var nomer=id.substring(3);
if (flag=='edt') {$('#inp'+nomer).toggle( 'display' );} else {
 
 $.get('ajax/editKat2.php?id='+this.id)
  .success(function(data) {
if (data!='') alert(data);
location.reload();
  });	
	
}

});

$('#appst').click(function(){
 window.location = "/?basket";
});

$('.vlimg').click(function(){
creatModalWindow (this.title);

return false;	
});

$(window).resize(function() {
if ($('.curtain').is(':visible')) {img();};
});

$('.modalWindow #img').load(function(){
var image = new Image();
image.src = $(this).attr("src");
im_h = image.naturalHeight;
im_w = image.naturalWidth;
img();
});

$('.modalWindow #img_l').mouseout(function() {
if (zoomEnable) {
  $('#fancybox-title-over').show();
  $('#photografer-over').show();
  var offset = $('.modalWindow #divimg').offset();
   $('.modalWindow #img').offset(offset)
   .height(Math.round(im_h/ratio))
   .width(Math.round(im_w/ratio));}
});

$('.modalWindow #img_l').click(function(){ // Что будет происходить по клику по ссылке
	if (zoomEnable) {zoomEnable=false;
		  $('#fancybox-title-over').show();
		  $('#photografer-over').show();
  var offset = $('.modalWindow #divimg').offset();
   $('.modalWindow #img').offset(offset)
   .height(Math.round(im_h/ratio))
   .width(Math.round(im_w/ratio));
   $('.modalWindow #img_l').removeClass('zoomout');}
	else {
		$('.modalWindow #img_l').addClass('zoomout');
		zoomEnable=true;
		$('.modalWindow #img').height(im_h)
		
	    .width(im_w);
$('#fancybox-title-over').hide();
$('#photografer-over').hide();
}


	return false;	
});
    		
  		
$('.modalWindow #img_l').mouseenter(function(){
	if (zoomEnable) {$('#fancybox-title-over').hide(); 	
	    $('#photografer-over').hide();
	    $('.modalWindow #img').height(im_h);
	    $('.modalWindow #img').width(im_w);	}
});

$('.modalWindow #img_l').mousemove(function(e){
	if (zoomEnable) {
	var offset = $('.modalWindow #divimg').offset();
	var divimg = $('.modalWindow #divimg');
	var img = $('.modalWindow #img');
    var X = -1*(((e.pageX - offset.left)/divimg.width())*(img.width()-divimg.width()))+offset.left;
    var Y = -1*(((e.pageY - offset.top)/divimg.height())*(img.height()-divimg.height()))+offset.top;
   img.offset({top:Y.toFixed(), left:X.toFixed()});}
});

$('.modalWindow').click(function(event){ //Что будет происходить по клику по форме
	b = Date.now();
	if (b - a>400) {
	 $('.modalWindow #img').removeAttr("width")
       .removeAttr("height")
       .css({ width: "", height: "" })
       .attr("src","img/foto.jpg");
		$(this).hide();
    	$('.curtain').hide();};
});
    		
$('#fancybox-title-over').click(function(event){ 
	a = Date.now();
});
  		
$('#right_b').click(function(event){ 
	$('.modalWindow #img').attr("src","img/foto.jpg");
	creatModalWindow (this.title);
	a = Date.now();
	return false;
});

$('#left_b').click(function(event){
	$('.modalWindow #img').attr("src","img/foto.jpg");
	creatModalWindow (this.title); 
    a = Date.now();
    return false;
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


$('.count_foto').change(function(){
foto_count($(this));
price();
});

$('.i_kom').change(function(){
foto_count($(this));
});


$("body").on("contextmenu", false);
$("body").on("selectstart", false);
$("body").on("dblclick", false);
$("body").on("dragstart", false);
$("body").on("click",function() {if(event.button != 0 || event.shiftKey || event.ctrlKey || event.altKey) return false;});

 jQuery("img.lazy").lazy();

});

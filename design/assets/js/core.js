$("body").on("contextmenu", false);
$("body").on("selectstart", false);
$("body").on("dblclick", false);
$("body").on("dragstart", false);
$("body").on("click",function() {if(event.button != 0) return false;});

function close_window(name){
    $('#' + name + '_page').toggleClass("hidden");
    $("#close").toggleClass("hidden");

    $('#content').toggleClass("blur");
    $('#wrapper').toggleClass("blur");
    $('footer').toggleClass("blur");
    $("body").css("overflow","auto");
};

function open_window(name){
    $("#close").removeClass("hidden");
    $('.page').addClass("hidden");
    $('#content').removeClass("blur");
    $('#wrapper').removeClass("blur");
    $('footer').removeClass("blur");
    $("body").css("overflow","auto");

    $('#' + name + '_page').removeClass("hidden");
    $("#close").removeClass("hidden");
    $("#close").attr("href", "javascript:close_window('" + name + "');");

    $('#content').addClass("blur");
    $('#wrapper').addClass("blur");
    $('footer').addClass("blur");
    $("body").css("overflow","hidden");
};

function zoom() {
    $('.fancybox-outer a').remove();
    $(".fancybox-image").wrap(
    $("<a></a>")
    .attr("href", $(".fancybox-image").attr("src")+'&big')
    .addClass("jqzoom")
    .attr("rel", "position: 'inside'")
    );
    $(".jqzoom").jqzoom({
    zoomType: "innerzoom",
    title: false,
    lens: false,
    showEffect: "fadein",
    hideEffect: "fadeout"
    });
}

$(document).ready(function() {
    $(".fancybox").fancybox({
        "afterShow": function () {
            $('.fancybox-outer').append("<a title='Zoom' class='fancybox-zoom' href='javascript:zoom();'></a>");
        },
		'loop'        :   false,
		'padding': 3,
        'openSpeed': 50,
        'closeSpeed': 50, 
        afterLoad: function() {
            //if (this.getAttribute("vl") == 0) {
	        var e=document.getElementById('vl-img').getElementsByTagName('a');
            for(var i=0;i<e.length;i++){ 
                if(e[i].title==this.title) {foto=e[i]; break;};
            };
        if (foto.getAttribute("vl") == 0) {
	        this.title = this.title + '<span id="fancybox-title-over"> <a href="javascript: add_basket ( null,\''+this.title+'\'); "><? echo Addphoto ?></a></span>';
	    }  else {
             this.title = this.title + ' <span id="fancybox-title-over"><? echo ALREADYincart; ?> <a href="javascript: add_basket ( null,\''+this.title+'\'); "><? echo deletephoto ?></a></span>';};
        },

		helpers	: {
			title	: {
				type: 'over'
			}
		}
	});
	
    jQuery("img.lazy").lazy();
	});

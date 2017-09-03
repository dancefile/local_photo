function openPhoto(url, name){
    $('#photo_page').removeClass("hidden");
    $("#close").toggleClass("hidden");

    $('#content').addClass("blur");
    $('#wrapper').addClass("blur");
    
    $("#close").attr("href", "javascript:close_window('photo');");

    $("#image").attr("src", "../img.jpeg?url=" + url + "&name=" + name);
    $("#name").html(name)

    $("html,body").css("overflow","hidden");
};

function plus(id){
    var val = parseInt($("#"+id).val());
    var ret = (val + 1);
    $("#"+id).val(ret);
}

function minus(id){
    var val = parseInt($("#"+id).val());
    var ret = (val - 1);
    if(val != 0){
        $("#"+id).val(ret);
    }
}
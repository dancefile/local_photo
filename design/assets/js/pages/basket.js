var A6 = 250;
var A5 = 300;
var A4 = 400;
var CD = 250;
var SK = 1;

var count_a6 = 0;
var count_a5 = 0;
var count_a4 = 0;
var count_cd = 0;

function plus(id, name){
	var val = parseInt($("#" + id + "_" + name + "[name=" +name +"]").val());
	var ret = val + 1;

	$("#" + id + "_" + name + "[name=" +name +"]").val(ret);

	if(id == "a6"){
		count_a6 = count_a6 + 1;
	}
	if(id == "a5"){
		count_a5 = count_a5 + 1;
	}
	if(id == "a4"){
		count_a4 = count_a4 + 1;
	}

	var sum_a6 = count_a6*A6;
	var sum_a5 = count_a5*A5;
	var sum_a4 = count_a4*A4;
	var sum_cd = count_cd*CD;

	var ret = sum_a6 + sum_a5 + sum_a4 + sum_cd;
	$("#sum").html(ret)
}

function minus(id, name){
	var val = parseInt($("#" + id + "_" + name + "[name=" +name +"]").val());
	var ret = (val - 1);
	if(val != 0){
		$("#" + id + "_" + name + "[name=" +name +"]").val(ret);
	}

	if(id == "a6" || count_a6 != 0){
		count_a6 = count_a6 - 1;
	}
	if(id == "a5" || count_a5 != 0){
		count_a5 = count_a5 - 1;
	}
	if(id == "a4" || count_a4 != 0){
		count_a4 = count_a4 - 1;
	}

	var sum_a6 = count_a6*A6;
	var sum_a5 = count_a5*A5;
	var sum_a4 = count_a4*A4;
	var sum_cd = count_cd*CD;

	var ret = sum_a6 + sum_a5 + sum_a4 + sum_cd;
	$("#sum").html(ret)
}
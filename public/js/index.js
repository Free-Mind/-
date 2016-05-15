//获取用户地理位置
$(function(){
	if (navigator.geolocation){
	    navigator.geolocation.getCurrentPosition(showPosition);
	}
	else{
		alert("不支持");
	}
	function showPosition(position)
	{
		//利用HTML5的localStorage来储存地理位置；
		localStorage.y = position.coords.latitude;
		localStorage.x = position.coords.longitude;
		$("#position-x").val(position.coords.latitude);
		$("#position-y").val(position.coords.longitude);
	}
});

function getSuggestion(){
		$(".suggestion").fadeIn(100);
		$(".cancel").show();
	//	var screen_width = document.body.clientWidth;
		var total_width = $(".container").width();
		console.log(total_width);
		var per_cancel = Math.round(39 / total_width * 10000) / 100.00 + "%";
		var per_input = (97-Math.round(39 / total_width * 10000) / 100.00)	+"%";
		$(".input-group").css("width",per_input);
		$(".cancel").css("width",per_cancel);
	}
function cancel(){
	$(".cancel").hide();
	$(".suggestion").fadeOut(100);
	$(".input-group").css('width',"100%");
}
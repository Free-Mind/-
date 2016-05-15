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
		alert("x:"+position.coords.latitude+"y:"+position.coords.longitude);
		localStorage.y = position.coords.latitude;
		localStorage.x = position.coords.longitude;
		$("#position-x").val(position.coords.latitude);
		$("#position-y").val(position.coords.longitude);
	}
});


$("#telphone").blur(function(){
	var phone = $("#telphone").val();
	//使用正则表达式进行校验
    if(!(/^1[3|4|5|7|8]\d{9}$/.test(phone))){ 
       $(".phone-wrong").show();
       $(".login-button").attr("disabled","disabled");
    }else{
    	 $(".phone-wrong").hide();
    	 $(".login-button").removeAttr("disabled");
    }
});
//表单提交
$("#login-button").click(function(){
	// var telphone = $("#telphone").val();
	// var password = $("#password").val();
	$.ajax({
		type: "POST",
		url: "handle_login",
		data:$("#form-signin").serialize(),
		success: function(data){
			if(data == "Success"){
				window.location.href = "./index";
			}else if(data == "Fail"){
				$(".password-wrong").show();
			}
		}
	});
});

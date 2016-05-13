//当前已点的菜品数量,价格,菜品Id
var total_price = 0;
var total_num = 0;
var food_ids = new Array();
var room_id = "";
$("#food-dav").on("tap",slide);
$("#room-dav").on("tap",slide);
$("#evaluation-dav").on("tap",slide);
//$("#evaluation-dav").on("tap",function(){$(this).hide();});

function slide(){
	/**
		用户点击酒店详情页面中：菜品，房间，评价时，发生的动画效果
		nav-line 元素滑动；字体颜色变化
	*/
	//设置滑动条宽度为container宽度的三分之一
	var screen_width = $(".container").width();
	var line_width = screen_width / 3;
//	var value = parseInt(obj.getAttribute('value'));
	var value = parseInt($(this).attr("value"));
	$(".nav-line")[0].style.transform = 'translate('+value*line_width+'px)';
	//字体颜色变化+不同div显示
	switch(value){
		case 0:
			$(".food").css({"color":"#ff4683"});
			$(".room").css({"color":"#111"});
			$(".evaluation").css({"color":"#111"});
			//菜品div显示，房间+评价div隐藏
			$(".food-detail").show();
			$(".room-detail").hide();
			$(".evaluation-detail").hide();
			break;
		case 1:
			$(".food").css({"color":"#111"});
			$(".room").css({"color":"#ff4683"});
			$(".evaluation").css({"color":"#111"});
			$(".food-detail").hide();
			$(".room-detail").show();
			$(".evaluation-detail").hide();
			break;
		case 2:
			$(".food").css({"color":"#111"});
			$(".room").css({"color":"#111"});
			$(".evaluation").css({"color":"#ff4683"});
			$(".food-detail").hide();
			$(".room-detail").hide();
			$(".evaluation-detail").show();
			break
	}

}

$(function hold_nav(){
	/**
	导航栏下拉到一定高度，自动固定
	*/
	var nav = $(".classfication-wrap");
	var win = $(window);
	var src = $(document);
	win.scroll(function(){
		if(src.scrollTop()>=271){
			nav.addClass('fixednav');
		}
		else{
			nav.removeClass('fixednav');
		}
	});
});

//将菜品添加到购物车触发函数
function add_food(id){
	var food_id;
	var food_price;
	if(id == "add-item"){
		$("#minus-item").show();
		$("#add-item").hide();
		food_id = $("#add-item").data("id");
		food_price = $("#add-item").data("price");
		//更新购物车里面的菜品id	
		food_ids.push(food_id);
		total_num++;
		total_price +=food_price;
	}
	else if(id == "minus-item"){
		$("#minus-item").hide();
		$("#add-item").show();
		food_id = $("#minus-item").data("id");
		food_price = $("#minus-item").data("price");
		//更新购物车里面的菜品id	
		for(var i=0;i<total_num;i++){
			if(food_ids[i] == food_id){
				food_ids.splice(i,1);
				break;
			}
		}
		total_num--;
		total_price -= food_price;	
	}
	$(".food-num").text(total_num);
	$(".total-price").text(total_price);
}
//提交订单按钮
$(".book-food-btn").on("tap",function(){
	//检查当前是否点菜
	if(total_num == 0){
		alert("您还没有点菜");
		return false;
	}
	//检查时间是否合法
	//获取到店用餐时间
	var time = $("#food-time").val();
	if(time == ''){
		alert("请选择到店时间");
		return false;
	}
	time +=":00:00";
	//序列化成时间戳
    var custom_time = new Date(time).getTime();
	var now_time = new Date().getTime();
	if(now_time>custom_time){
		alert("不能选择过去的时间");
		return false;
	}

	//序列化菜品数组
	var food = '';
	for(var i=0;i<food_ids.length;i++){
		food += food_ids[i]+'&';
	}

	var hotel_id = $(".book-food-btn").data("hotelid");
	var order_id = $(".book-food-btn").data("orderid");
	$.ajax({
		type:"POST",
		url:"../handle_order",
		data:{'foods_id':food,"total_price":total_price,"time":custom_time,
				"hotel_id":hotel_id,"order_id":order_id},
		success:function(msg){
			if(msg == "success"){
				alert("预订成功！请去订单中心查看");
			}else{
				alert("预订失败");
			}
		},
		error:function(jqXHR,textStatus,errorThrown){
			alert(jqXHR.responseText+":"+jqXHR.status+":"+jqXHR.readyStatus+":"+jqXHR.statusText);
			alert(textStatus);
			alert(errorThrowno);
		}
	});
});
//时间选择器
$(function () {
			var currYear = (new Date()).getFullYear();	
			var currMonth = (new Date()).getMonth();
			var currDay = (new Date()).getDay();
			var opt={};
			opt.date = {preset : 'date'};
			opt.datetime = {preset : 'datetime'};
			opt.time = {preset : 'time'};
			opt.default = {
				theme: 'android-ics light', //皮肤样式
		        display: 'modal', //显示方式 
		        mode: 'scroller', //日期选择模式
				dateFormat: 'yyyy-mm-dd',
				lang: 'zh',
				showNow: true,
				nowText: "今天",
		        startYear: currYear, //开始年份
		        endYear: currYear, //结束年份
		        startMonth:currMonth,
		        startDay:currDay
			};
		  	var optDateTime = $.extend(opt['datetime'], opt['default']);
		  	var optTime = $.extend(opt['time'], opt['default']);
		    $("#food-time").mobiscroll(optDateTime).datetime(optDateTime);
		    $("#room-time").mobiscroll(optDateTime).datetime(optDateTime);
});

//点击预订，将当前房间id锁定
$(".book-btn").on('click',function(){
	room_id = $(this).data("id");
});
//点击模态框中的预订，提交预订房间订单
$(".book-room-btn").on('click',function(){
	//获取到店时间
	var time = $("#room-time").val()+":00:00";
	var room_custom_time = new Date(time).getTime();
	var now_time = new Date().getTime();
	var hotel_id = $(".book-room-btn").data("id");
	var order_id = $(".book-room-btn").data("orderid");
	if(now_time>room_custom_time){
		alert("不能选择过去的时间");
		return false;
	}
	$.ajax({
		type:"post",
		url:"../handle_order",
		data:{"room_id":room_id,"time":room_custom_time,"hotel_id":hotel_id,"order_id":order_id},
		success:function(msg){
			if(msg == "success"){
				alert("房间预成功！请去订单中心查看");
				//关闭模态框
				$("#myModal").modal('hide');
				//刷新页面
				location.reload(true);
			}else{
				alert("预订失败");
			}
		}
	});
});
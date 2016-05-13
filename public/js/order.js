//点击“去订房”、“去点餐”，触发的事件
$(".change-btn").on('click',function(){
	var o_id = $(this).data("id");
	var base_url = $(this).data("base");
	window.location.href = base_url+"controller/modify_order/"+o_id;
});
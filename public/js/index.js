function getSuggestion(){
		$(".suggestion").fadeIn(100);
		$(".cancel").show();
	//	var screen_width = document.body.clientWidth;
		var total_width = $(".container").width();
		console.log(total_width);
		var per_cancel = Math.round(39 / total_width * 10000) / 100.00 + "%";
		var per_input = (97-Math.round(39 / total_width * 10000) / 100.00)	+"%";
		// console.log(per_input);
		// console.log(per_cancel);
		$(".input-group").css("width",per_input);
		$(".cancel").css("width",per_cancel);
	}
	function cancel(){
		$(".cancel").hide();
		$(".suggestion").fadeOut(100);
		$(".input-group").css('width',"100%");
	}
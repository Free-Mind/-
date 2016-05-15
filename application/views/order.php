<!DOCTYPE html>
<html lang='zh-CN'>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" />
	<title>Order</title>
	<link href=<?php echo $path['css'].'/bootstrap.min.css'?> rel="stylesheet">
	<link href=<?php echo $path['css'].'/order.css'?> rel="stylesheet">
	<link href=<?php echo $path['css'].'/font-awesome/css/font-awesome.min.css'?> rel="stylesheet">
</head>
<body>
	<div class="container">
		<!--头部信息-->
		<header>
			<div class="navigation">
				<div class="back">
					<i class="fa fa-arrow-left fa-lg backIcon"></i>
				</div>
				<div class="title">
					订单详情
				</div>
				<div class="abort-wrap">
					<p class="abort">取消订单</p>
				</div>
			</div>
		</header>
		<div class="room-item-wrap">
<?php
	if(!empty($order_detail['room_item'])){
?>
			<div class="img-wrap">
				<img class="room-img" src="<?php echo $path['image'].'/5.jpg'?>">
			</div>
			<div class="info-wrap">
				<div class="room-name">
					<p><?php echo $order_detail['room_item']['r_name']?></p>
				</div>
				<div class="intro-wrap">
					<div class="desc-wrap">
						<p class="desc">餐厅描述：</p>
						<p class="desc-content"><?php echo $order_detail['room_item']['r_desc']?></p>
					</div>
					<div class="cat-wrap">
						<p class="cat">餐厅类型：</p>
<?php
		if($order_detail['room_item']['r_cat']==1){
?>
						<p class="cat-content">豪华间</p>
<?php
		}else{
?>						
						<p class="cat-content">经济间</p>
<?php
		}
?>	
					</div>
				</div>
			</div>
<?php
	}else{
?>
				<div class="change-wrap">
					<button data-id="<?php echo $order_detail['order_item']['o_id']?>" data-base="<?php echo $base_url;?>" type="button" class="btn btn-default change-btn">去定房间</button>
				</div>
<?php
	}
?>

		</div>
		
		<div class="food-item-wrap">
			<div class="food-title">
				<p>已点菜品</p>
			</div>
<?php
	if(!empty($order_detail['foods_data'])){
		foreach($order_detail['foods_data'] as $food_item){		
?>			
			<div class="food-wrap">	
				<div class="food-img-wrap">
					<img class="food-img" src="<?php echo $path['image'].'/1.jpg'?>">
				</div>
				<div class="food-info-wrap">
					<div class="food-name-wrap">
						<p class="food-name"><?php echo $food_item['f_name']?></p>	
					</div>
					<div class="food-intro-wrap">
						<p class="food-intro"><?php echo $food_item['f_desc']?></p>	
					</div>
					<div class="sale-wrap">
						<p class="food-sale"><?php echo "共售出".$food_item['f_sale_num']."份     共".$food_item['f_eval_num']."份评价"?></p>
					</div>
					<div class="add-price">
						<div class="price-wrap">
							<p class="food-price"><?php echo "￥".$food_item['f_price']?></p> 
						</div>
					</div>
				</div>
			</div>
<?php
		}
	}else{
		echo "当前未点菜";
	}	
?>
		</div>
<?php 
	if(empty($order_detail['foods_data'])){
?>
		<div class="saveorabort-group">
			<button data-id="<?php echo $order_detail['order_item']['o_id']?>" data-base="<?php echo $base_url;?>"type="button" class="btn btn-default change-btn">去点菜</button>
		</div>
<?php
	}
?>
	</div>
</body>
<script src=<?php echo $path['js'].'/jquery-2.2.1.min.js'?>></script>
<script src=<?php echo $path['js'].'/order.js'?>></script>
</html>
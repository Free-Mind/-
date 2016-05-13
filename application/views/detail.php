<!DOCTYPE html>
<html lang='zh-CN'>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" />
	<title>Detail</title>
	<link href=<?php echo $path['css'].'bootstrap.min.css'?> rel="stylesheet">
	<link href=<?php echo $path['css'].'detail.css'?> rel="stylesheet">
	<link href=<?php echo $path['css'].'font-awesome/css/font-awesome.min.css'?> rel="stylesheet">
	<link href=<?php echo $path['js'].'/jquery.mobile-1.4.5/jquery.mobile-1.4.5.css'?> rel="stylesheet">
	<link href=<?php echo $path['css'].'mobiscroll.css'?> rel="stylesheet">
	<link href=<?php echo $path['css'].'mobiscroll_002.css'?> rel="stylesheet">
	<link href=<?php echo $path['css'].'mobiscroll_003.css'?> rel="stylesheet">
	<!-- <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css"> -->
</head>
<body>
	<div class="container">
		<!--网页头部-->
		<header>
			<div class="navigation">
				<a href="<?php echo $base_url.'controller/index'?>">	
					<div class="back">
						<i class="fa fa-arrow-left fa-lg backIcon"></i>
					</div>
				</a>
				<div class="title">
					商家详情
				</div>
				<div class="dropdown">
					<i class="fa fa-list-ul fa-lg listIcon dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" id="dropdownMenu1"></i>
					<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						<li><a href="<?php echo $base_url.'controller/index'?>" style="color: white">首页</a></li>
						<li><a href="<?php echo $base_url.'controller/personal'?>" style="color: white">个人中心</a></li>
					</ul>
				</div>
			</div>
		</header>
		
		<!--酒店展示-->
		<div class="detail-image">
			<div class="picture">
				<img class="pic-item" src="<?php echo $path['image'].'/1.jpg'?>">
			</div>
			<div class="tip">点击图片查看相册</div>
		</div>
		<!--酒店介绍-->
		<div class="intro">
			<div class="name">
				<?php echo $detail_data['hotel_detail']['h_name'];?>
			</div>
			<div class="info">
				<?php echo $detail_data['hotel_detail']['h_desc']?>
			</div>
		</div>
		<!--条目-->
		<div class="classfication-wrap">
			<div class="classfication">
				<a href="#food"><div id="food-dav" class="food" value=0 style="color:#ff4683">菜品</div></a>
				<a href="#room"><div id="room-dav" class="room" value=1>房间</div></a>
				<a href="#evaluation"><div id="evaluation-dav" class="evaluation" value=2>评价</div></a>
			</div>
			<span class="nav-line" style="width:33.3333%;visibility:visible;transform:translate(0px);"></span>
		</div>
		<!--内容-->
		<div class="content">
			<a name="food"></a>
			<div class="food-detail">
<?php
	foreach($detail_data['hotel_foods'] as $hotel_food){
?>
				<div class="food-item-wrap" id="<?php echo $hotel_food['f_id']?>">
					<div class="img-wrap">
						<img class="food-img" src="<?php echo $path['image'].'/1.jpg'?>">
					</div>
					<div class="info-wrap">
						<div class="name-wrap">
							<p class="food-name"><?php echo $hotel_food['f_name']?></p>	
						</div>
						<div class="intro-wrap">
							<p class="food-intro"><?php echo $hotel_food['f_desc']?></p>	
						</div>
						<div class="sale-wrap">
							<p class="food-sale"><?php echo "共售出".$hotel_food['f_sale_num']."单   "."共有".$hotel_food['f_eval_num']."份评价"?></p>
						</div>
						<div class="add-price">
							<div class="price-wrap">
								<p class="food-price"><?php echo "￥".$hotel_food['f_price']?></p> 
							</div>
							<div class="add-wrap">
								<?php
									if($hotel_food['f_status'] == 1){
								?>
									<i data-id="<?php echo $hotel_food['f_id']?>" data-price="<?php echo $hotel_food['f_price']?>" id="add-item" class="fa fa-plus-circle fa-2x" value="1" onclick="add_food(this.id)"></i>
									<i data-id="<?php echo $hotel_food['f_id']?>" data-price="<?php echo $hotel_food['f_price']?>" style="display: none" id="minus-item" class="fa fa-minus-circle fa-2x" value="1" onclick="add_food(this.id)"></i>
								<?php
									} else{
								?>
									<p>该美味暂时下线</p>
								<?php
									}
								?>
							</div>
						</div>
					</div>
				</div>
<?php 
}
?>
<?php 
	if(!isset($food_ordered)){
?>
			<div class="shopping-cart">
				<div class="food-num-wrap">
					<p style="display: inline-block;">共点</p>
					<p style="display: inline-block;" class="food-num">0</p>
					<p style="display: inline-block;">道菜</p>
				</div>
				<div class="total-price-wrap">
					<p style="display: inline-block;">总价</p>
					<p style="display: inline-block;" class="total-price">0</p>
					<p style="display: inline-block;">元</p>
				</div>
<?php
	if(!isset($room_ordered)){
?>
				<div class="picktime-wrap">
					<input  class="" readonly="readonly"id="food-time" type="text">
				</div>
<?php
	}
?>
				<div class="button-wrap">
					<button data-hotelId="<?php echo $detail_data['hotel_detail']['h_id'];?>" type="button" data-orderId = "<?php
						if(isset($order_id))
							echo $order_id;
					?>"class="book-food-btn" style="background: #ff4978;
							color:white;font-weight: bold;">下单</button>
				</div>
			</div>
<?php
	}
?>
		</div><!--<div class="food-detail">-->
			<a name="room"></a>
			<div class="room-detail">
<?php 
foreach($detail_data['hotel_rooms'] as $hotel_room){
?>
				<div class="room-item-wrap">
					<div class="img-wrap">
						<img class="room-img" src="<?php echo $path['image'].'/1.jpg'?>">
					</div>
					<div class="info-wrap">
						<div class="room-name">
							<p><?php echo $hotel_room['r_name']?></p>
						</div>
						<div class="intro-wrap">
							<p class="size"><?php echo $hotel_room['r_desc']?></p>
							<p class="cat">
							<?php 
							if($hotel_room['r_cat'] == 1)
								echo "豪华包间：最低消费￥1000";
							else if($hotel_room['r_cat'] == 2)
								echo "经济包间：最低消费￥100";
							?>
							</p>
						</div>
						<div class="book-wrap">
							<?php 
								if(!isset($room_ordered)){
									if($hotel_room['r_status'] == 1){
							?>
								<button data-id="<?php echo $hotel_room['r_id']?>" 
								type="button" class="btn btn-default book-btn"data-toggle="modal" data-target="#myModal">预订</button>
							<?php
									}else{
							?>
								<p>房间已被预定！</p>
							<?php
									}
								}
							?>
						</div>
					</div>
				</div>
<?php
}
?>
<!-- 				<div class="more">
					查看更多
				</div>	
 -->		</div>
			<a name="evaluation"></a>
			<div class="evaluation-detail">
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Modal title</h4>
				</div>
				<div class="modal-body">
<?php
	if(!isset($food_ordered)){
?>
					<p>选择到店时间:</p>
					<input  class="" readonly="readonly" id="room-time" type="text">
<?php
	}else{
?>
					<p>确定修改成此房间？</p>
<?php
	}
?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
					<button data-id="<?php echo $detail_data['hotel_detail']['h_id'];?>" 
					data-orderId = "<?php
									if(isset($order_id))
										echo $order_id;
									?>"
					type="button" class="btn btn-primary book-room-btn">预订</button>
				</div>
			</div>
		</div>
	</div>

</body>
<script src=<?php echo $path['js'].'/jquery-2.2.1.min.js'?>></script>
<script src=<?php echo $path['js'].'/jquery.mobile-1.4.5/jquery.mobile-1.4.5.js'?>></script>
<script src=<?php echo $path['js'].'/bootstrap.min.js'?>></script>
<script src=<?php echo $path['js'].'/mobiscroll_002.js' ?>></script>
<script src=<?php echo $path['js'].'/mobiscroll_004.js' ?>></script>
<script src=<?php echo $path['js'].'/mobiscroll.js' ?>></script>
<script src=<?php echo $path['js'].'/mobiscroll_003.js' ?>></script>
<script src=<?php echo $path['js'].'/mobiscroll_005.js' ?>></script>
<script src=<?php echo $path['js'].'/detail.js'?>></script>
</html>
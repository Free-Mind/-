<!DOCTYPE html>
<html lang='zh-CN'>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" />
	<title>Account</title>
	<link href=<?php echo $path['css'].'/bootstrap.min.css'?> rel="stylesheet">
	<link href=<?php echo $path['css'].'/account.css'?> rel="stylesheet">
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
					我的账户
				</div>
				<div class="list">
					<i class="fa fa-home fa-lg listIcon"></i>
				</div>
			</div>
		</header>
		<div class="all-order-wrap">
			<div class="order-content">
<?php
	foreach($order_data as $order_item){
?>
				<a href="<?php echo $base_url.'controller/order_detail/'.$order_item['o_id']?>">
					<div class="order-item">
						<div class="img-wrap">
							<img src="<?php echo $path['image'].'/1.jpg'?>">
						</div>
						<div class="info-wrap">
							<div class="name-wrap">
								<p class="hotel-name"><?php echo $order_item['h_name']?></p>
							</div>
							<!--根据订单状态判定显示内容-->
							<div class="food-status">
<?php 
	if(!empty($order_item['f_id'])){
?>
								<div class="food-done-wrap">
									<i class="fa fa-check-circle done-icon" style="display:inline"></i>
									<p class="food-done" style="display:inline">已点餐</p>
								</div>
<?php
	}else{
?>
								<div class="food-doing-wrap">
									<i class="fa fa-exclamation-circle doing-icon" style="display:inline"></i>
									<p class="food-doing" style="display:inline">未点餐</p>
								</div>	
<?php
	}
?>
							</div>
							<div class="room-status">
<?php
	if(!empty($order_item['r_id'])){
?>
								<div class="room-done-wrap">
									<i class="fa fa-check-circle done-icon" style="display:inline"></i>
									<p class="room-done" style="display:inline">已定房</p>
								</div>
<?php
	}else{
?>
								<div class="room-doing-wrap">
									<i class="fa fa-exclamation-circle doing-icon" style="display:inline"></i>
									<p class="room-doing" style="display:inline">未定房</p>
								</div>
<?php
	}
?>
							</div>
							<div class="arrive-time-wrap">
<?php
	if($order_item['status']==1){
?>
								<p><?php echo "预计到店时间： ".date('Y-m-d H:i:s',$order_item['time']/1000)?></p>
<?php
	}else{
?>								
								<p class="warning">订单已结束</p>
<?php
	}
?>							
							</div>
						</div>
					</div><!--order-item-->
				</a>
<?php
}
?>
			</div>
		</div>
	</div>
	
</body>
<script src=<?php echo $path['js'].'/jquery-2.2.1.min.js'?>></script>
<script src=<?php echo $path['js'].'/bootstrap.min.js'?>></script>
<script src=<?php echo $path['js'].'/account.js'?>></script>
</html>
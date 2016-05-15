<!DCOTYPE html>
<html lang='zh-CN'>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" />
	<title>Index</title>
	<link href=<?php echo $path['css'].'/bootstrap.min.css'?> rel="stylesheet">
	<link href=<?php echo $path['css'].'/index.css'?> rel="stylesheet">
</head>
<body>
	<div class="container">
		<header class="title">
			<div class="header">
				<div class="city-name">北京</div>
				<div class="account"><a style="color:white;text-decoration:none"href="<?php echo $base_url.'controller/account'?>">我的</a></div>
			</div>
		</header>
		<form>
			<div class="form">
				<div class="input-group">
				<input type="text" class="form-control" placeholder="请输入商家" aria-describedby="basic-addon1" onclick="getSuggestion()"/>
				</div>
				<div class="cancel" onclick="cancel()">
					<div class="cancel-button">关闭</div>
				</div>
			</div>
		</form>
		<div class="suggestion">
				<ul class="list-group">
					<li class="list-group-item">酒店1</li>
					<li class="list-group-item">酒店1</li>
					<li class="list-group-item">酒店1</li>
					<li class="list-group-item">酒店1</li>
				</ul>
		</div>
		<div class="mask"></div>
		<div class="content">
			<!--猜你喜欢-->
<?php if(isset($recommend_hotel)){
?>
 			<div calss="recommend-wrap">
				<p class="recommend-title">猜你喜欢</p>
<?php
	foreach($recommend_hotel as $recommend_item){
?>
				<a href="#">
					<section class="content-class">
						<div class="img-wrapper">
							<image src="<?php echo $path['image'].'/1.jpg'?>">
						</div>
						<div class="info-wrapper">
							<div class="title-line">
								<div class="title">
									<p class="item-name"><?php echo $recommend_item['h_name']?></p>
								</div>
							</div>
							<p class="desc"><?php echo $recommend_item['h_desc']?></p>
							<div class="address-line">
								<p class="address"><?php echo $recommend_item['h_address']?></p>

<?php
		if(isset($recommend_item['distance'])){
?>
								<p class="distance">距离您16千米</p>
<?php
		}
?>
							</div>
						</div>
					</section>
				</a>
<?php
		
	}
}
?>
			</div> 
			<!--条件栏-->
			<div class="conditions">
				<div class="eval_num_wrap">
					<a href=<?php echo $base_url.'controller/index/1'?>><button class="btn btn-default dropdown-toggle good-eval-first" type="button">
					好评优先
					<span class="caret"></span>
					</button></a>
				
				</div>
				
				<div class="distance_wrap">
					<a href="<?php echo $base_url.'controller/index/2'?>"><button class="btn btn-default dropdown-toggle distance-first" type="button">
					离我最近
					<span class="caret"></span>
					</button>
				</div>

				<div class="sale_num_wrap">
					<a href="<?php echo $base_url.'controller/index/3'?>"><button class="btn btn-default dropdown-toggle slae-num-first" type="button">
					销量最多
					<span class="caret"></span>
					</button></a>
				</div>
			</div>

<?php 
	foreach($hotel_data as $item){
?>
			<a href="<?php echo $base_url."controller/detail/".$item['h_id']?>">
				<section class="content-class">
					<div class="img-wrapper">
						<image src="<?php echo $path['image'].'/1.jpg'?>">
					</div>
					<div class="info-wrapper">
						<div class="title-line">
							<div class="title">
								<p class="item-name"><?php echo $item['h_name']?></p>
							</div>
						</div>
						<p class="desc"><?php echo $item['h_desc']?></p>
						<div class="address-line">
							<p class="address"><?php echo $item['h_address']?></p>
<?php
if(isset($item['distance'])){
?>
							<p class="distance"><?php echo "距离您".round($item['distance'],2)."公里"?></p>
<?php
}
?>
						</div>
					</div>
				</section>
			</a>
<?php
	}
?>
		</div>
	</div>
</body>
<script src=<?php echo $path['js'].'/jquery-2.2.1.min.js'?>></script>
<script src=<?php echo $path['js'].'/bootstrap.min.js'?>></script>
<script src=<?php echo $path['js'].'/index.js'?>></script>
</html>
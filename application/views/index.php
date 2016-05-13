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
				<div class="account"><a style="color:white;text-decoration:none"href="#">我的</a></div>
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
<?php 
	foreach($hotel_data as $item){
?>
			<a href="<?php echo "./detail/".$item['h_id']?>">
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
							<p class="distance">距离您16千米</p>
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
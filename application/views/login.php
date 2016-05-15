<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" />
    	<title>Login</title>
		<link href=<?php echo $path['css'].'/bootstrap.min.css'?> rel="stylesheet">
		<link href=<?php echo $path['css'].'/signin.css'?> rel="stylesheet">
	</head>
	<body>
		<div class="container">
	      <form id="form-signin" class="form-signin">	
	        <h2 class="form-signin-heading">登录</h2>
	        <label for="inputEmail" class="sr-only">手机</label>
	        <input id="telphone" name="telphone"type="text" class="form-control" placeholder="手机号码" required autofocus>
	        <div class="alert alert-danger phone-wrong" role="alert" style="display: none;">请输入正确的手机号！</div>
	        <label for="inputPassword" class="sr-only">密码</label>
	        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="密码" required>
	        <div class="alert alert-danger password-wrong" role="alert" style="display: none;">用户名或者密码错误！</div>
	        <input style="display: none;" id="position-x" name="x" value="">
	        <input style="display: none;" id="position-y" name="y" value="">
	        <button class="btn btn-lg btn-primary btn-block login-button" id="login-button" type="button">登录</button>
	      </form>
    	</div>
	</body>
<script src=<?php echo $path['js'].'/jquery-2.2.1.min.js'?>></script>
<script src=<?php echo $path['js'].'/bootstrap.min.js'?>></script>
<script src=<?php echo $path['js'].'/login.js'?>></script>>
</html>
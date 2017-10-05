<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>笺记控制台 | 登录</title>

	<link href="//uozi.oss-cn-hangzhou.aliyuncs.com/resources/admin/css/bootstrap.min.css" rel="stylesheet">
	<link href="//uozi.oss-cn-hangzhou.aliyuncs.com/resources/admin/font-awesome/css/font-awesome.css" rel="stylesheet">

	<link href="//uozi.oss-cn-hangzhou.aliyuncs.com/resources/admin/css/animate.css" rel="stylesheet">
	<link href="//uozi.oss-cn-hangzhou.aliyuncs.com/resources/admin/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen animated fadeInDown">
	<div>
		<div>

			<h1 class="logo-name">笺</h1>

		</div>
		<h3>欢迎来到笺记控制台</h3>
		<p>请登录</p>
		<?php echo validation_errors(); ?>

		<?php echo form_open('admin/login'); ?>
			<div class="form-group">
				<input type="text" name="username" value="<?php echo set_value('username'); ?>" class="form-control" placeholder="用户名" >
			</div>
			<div class="form-group">
				<input type="password" name="password" value="<?php echo set_value('password'); ?>" class="form-control" placeholder="密码" >
			</div>
			<button type="submit" class="btn btn-primary block full-width m-b">登录</button>

		</form>
		<p class="m-t"> <small>笺记 &copy; 2016 - 2017</small> </p>
	</div>
</div>

<!-- Mainly scripts -->
<script src="//uozi.oss-cn-hangzhou.aliyuncs.com/resources/admin/js/jquery-3.1.1.min.js"></script>
<script src="//uozi.oss-cn-hangzhou.aliyuncs.com/resources/admin/js/bootstrap.min.js"></script>

</body>

</html>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="../../css/main.css" />
		<title>简易版</title>
	</head>
	<body>
	<?php
		$name = $_POST['username'];
		$password = $_POST['password'];
		if( (!isset($name)) || (!isset($password)) 
			|| empty($name) || empty($password) ) {
	?>
		<h1> 请先登录！（用户名：user，密码：123） </h1>
		<p> This page is secret~~</p>
		<form action="secret.php" method="post">
			<p>用户名:<input type="text" name="username" /></p>
			<p>密　码:<input type="password" name="password" /></p>
			<p><input type="submit" value="Log In" /></p>
		</form>
	<?php
		} else if ( ($name == 'user') && ($password == '123') ){
			echo "<h1> 登录成功！ </h1>
				  <p>您是超级VIP用户！！！！！！！！！！！！！！！！！1</p>";
		} else {
			echo "<h1>请离开!</h1>
				  <p>你未被授权访问！</p>";
		}
	?>
	</body>
</html>
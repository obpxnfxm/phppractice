<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="../../css/main.css" />
		<title>使用 mysql 版</title>
	</head>
	<body>
<?php
	$name = $_POST['username'];
	$pwd = $_POST['password'];

	if( (!isset($name)) || (!isset($pwd)) || empty($name) || empty($pwd) ){
?>

		<h1> (mysql版)请先登录！（用户名：user，密码：123） </h1>
		<form action="secretdb.php" method="post">
			<p>用户名:<input type="text" name="username" /></p>
			<p>密　码:<input type="password" name="password" /></p>
			<p><input type="submit" value="Log In" /></p>
		</form>
<?php
	} else {
		// connet to mysql 
		$mysql = mysqli_connect('localhost', 'leo', '402');
		if(!$mysql) {
			echo "数据库连接失败!";
			exit;
		} 
		mysqli_select_db($mysql, "webuser");
		$query = "select count(*) from user where name = '".$name."' and password = '".$pwd."'";
		$result = mysqli_query($mysql, $query);
		if(!$result){
			echo "Cannot run query.";
			exit;
		}
		$row = mysqli_fetch_row($result);
		$count = $row[0];

		if($count > 0){
			echo "<h1>登录成功!</h1>
				  <p>您是授权用户，欢迎来访！！！！</p>";
		} else {
			echo "<h1>登录失败！</h1>
			      <p>您可以以游客的身份在此游玩，欢迎欢迎~~~</p>";
		}
	}
?>
	</body>
</html>
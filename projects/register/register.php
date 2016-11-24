<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>注册结果</title>
</head>
<body>
	<?php
		$user = $_POST['username'];
		$pwd = $_POST['password'];
		$pwd_enc = md5($pwd);
		$role = 0;       //1 管理员，0, 普通用户

		if (!isset($user) || !isset($pwd) || empty($user) || empty($pwd)) {
			echo "信息填写不正确，请重新填写!";
			echo "<br /><button onclick=\"return window.history.go(-1);\">返回</button>";
			exit;
		}

		@$db_conn = new mysqli('localhost', 'leo', '402', 'webuser');

		if (!$db_conn) {
			echo 'Connection to database failed:'.mysqli_connect_error();
			exit();
		}

		// 判断用户名是否已被注册
		$query = "select id from auth_users "
				."where user='".$user."'";
		$result = $db_conn->query($query);
		if ($result->num_rows) {
			echo "用户名已存在，请重新输入！";
			echo "<br /><button onclick=\"return window.history.go(-1);\">返回</button>";
			exit;
		}

		$query2 = "insert into auth_users(user, password, role) ".
		          "values( '".$user."', '".$pwd_enc."', ".$role.")";
		$result2 = $db_conn->query($query2);
		if(!$result2) {
			echo "用户注册失败，数据库插入错误！";
		} else {
			echo "<h1>注册成功</h1>";
		}
		$db_conn->close();
		//echo "<button onclick=\"return window.history.go(-1);\">返回</button>";

	?>
	<br />
	<button onclick="return window.history.go(-1);">返回</button>
</body>
</html>

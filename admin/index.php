<?php
    session_start();

    	if( isset($_POST['userid']) && isset($_POST['password']) )
    	{
    		// if the user has just tried to log in
    		$userid = $_POST['userid'];
    		$password = $_POST['password'];
    		$password_md5 = md5($password);

    		$db_conn = new mysqli('localhost', 'leo', '402', 'webuser');

    		if(mysqli_connect_errno()){
    			echo '数据库连接错误:'.mysqli_connect_error();
    			exit();
    		}

    		$query = "select id from auth_users ".
    		         "where user='$userid' ".
    		         "and password='$password_md5'";
    		//print_r($query);
    		$result = $db_conn->query($query);
    		if ($result->num_rows){
    			// if they are in the database register the user_id
    			$_SESSION['valid_user'] = $userid;
    		}
    		$db_conn->close();
    	}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>后台管理</title>
		<link rel="stylesheet" href="../css/main.css" />
		<script type="text/javascript">
			window.onload=function(){
				var form = document.getElementById("login");
				if(form){
						document.onkeydown=function(event){
						if (event.keyCode==13) {
							form.submit();
						}
					}
				}
			}
		</script>
	</head>
	<body>
		<?php
    	if(isset($_SESSION['valid_user']))
    	{
    		echo '欢迎你，'.$_SESSION['valid_user']; 
    		echo ' | <a href="logout.php">退出</a><br />';
    		echo '<p><a href="project.php"> 进入项目列表后台管理</a></p>';
    	} else {
    		if(isset($userid)){
    			// if they've tried and failed to log in
    			echo '<div class="aligncenter">登录失败!</div>';
    		} else {
    			// they have not tried to log in yet or have logged out
    			echo '<div class="aligncenter">请先登录!</div>';
    		}

    		// provide form to log in
    		echo '<table>';
    		echo '<form method="post" action="index.php" id="login">';
    		echo '<tr><td>用户名:</td>';
    		echo '<td><input type="text" name="userid" /></td></tr>';
    		echo '<tr><td>密码:</td>';
    		echo '<td><input type="password" name="password" /></td></tr></form>';
    		echo '<tr><td colspan="2" class="aligncenter">';
    		echo "<button id=\"submit\" onclick=\"return document.getElementById('login').submit();\"> 登录 </button> ";
    		echo "<button onclick=\"return window.location.href='../';\";>返回</button></td></tr></table>";
    	}
    ?>
    <br />
	</body>
</html>
<?php
	session_start();
	if(!$_SESSION['valid_user']){
		echo '<!DOCTYPE html><html><head>'
			.'<meta http-equiv="Content-Type" content="text/html; charset=utf-8">'.'<title>删除项目</title></head><body>';
		echo "<p>您未授权访问此页面</p>";
		echo "<p>3 秒后自动跳转</p>";
		echo '<script type="text/javascript">setTimeout("window.location.href=\"index.php\"",3000);</script>';
		echo '</body></html>';
		exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>删除项目</title>
</head>
<body>
<?php
	$id = $_GET['id'];
	$dsn = "mysql:dbname=webuser;host=localhost;charset=utf8";
	$user = 'leo';
	$password = "402";

	try{
		$dbh = new PDO($dsn, $user, $password);
	} catch (PDOException $e){
		echo "Connection failed: ". $e->getMessage();
	}

	$query = "delete from project where id =".$id;
	$result = $dbh->query($query);
	if($result){
		echo "Delete Success!<br />";
		echo "<a href=\"project.php\">返回</a>";
	} else {
		echo "删除失败!";
	}
?>
</body>
</html>
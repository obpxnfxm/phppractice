<?php
	session_start();
	if(!$_SESSION['valid_user']){
		echo '<!DOCTYPE html><html><head>'
			.'<meta http-equiv="Content-Type" content="text/html; charset=utf-8">'.'<title>添加项目</title></head><body>';
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
    <title>添加项目</title>
</head>
<body>
<?php
	declare(encoding='UTF-8');

	$name = addslashes($_POST['projectname']);
	$intro = addslashes($_POST['introduction']);
	//date_default_timezone_set('Asia/Shanghai');
	$time = time()+8*60*60; //本地时间戳

	if(!isset($name) || empty($name)){
		die("项目名称不能为空");
	}

	$dsn = "mysql:dbname=webuser;host=localhost;charset=utf8";
	$user = "leo";
	$password = "402";

	try{
		$dbh = new PDO($dsn, $user, $password);
	} catch (PDOException $e) {
		echo "Connection failed: ". $e->getMessage();
		exit;
	}

	$query = "insert into project(name, intro, time, mtime) values('".$name."', '".$intro."', '".$time."', '".$time."')";
	$result = $dbh->query($query);

	if($result){
		$rows = $result->rowCount();
		echo $rows." project(s) inserted into databases";
	} else {
		echo "A error has occurred. The item was not added!";
	}

	echo '<br/><a href="project.php">返回</a>';
?>
</body>
</html>
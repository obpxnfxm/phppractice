<?php
	session_start();
	if(!$_SESSION['valid_user']){
		echo '<!DOCTYPE html><html><head>'
			.'<meta http-equiv="Content-Type" content="text/html; charset=utf-8">'.'<title>修改项目</title></head><body>';
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
    <title>修改项目</title>
</head>
<body>
<?php
	declare(encoding='UTF-8');

	$name = addslashes($_POST['projectname']);
	$intro = addslashes($_POST['introduction']);
	$id = $_POST['id'];
	$mtime = time()+8*60*60; //本地时间戳

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

	$query = "update project set name='".$name."', mtime='".$mtime."', intro='".$intro."' where id=".$id;
	$result = $dbh->query($query);

	if($result){
		$rows = $result->rowCount();
		echo $rows." item(s) modified!";
	} else {
		echo "A error has occurred. The item was not added!";
	}

	echo '<br/><a href="project.php">返回</a>';
?>
</body>
</html>
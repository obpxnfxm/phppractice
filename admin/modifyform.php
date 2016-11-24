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
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>修改项目</title>
</head>
<body>
<?php
	$id = $_GET['id'];
	$dsn = "mysql:dbname=webuser;host=localhost;charset=utf-8";
	$user = "leo";
	$pwd = "402";
	try{
		$dbh = new PDO($dsn, $user, $pwd);
	} catch(PDOException $e){
		echo "Connection failed: ".$e->getMessage();
		exit;
	}
	$query = "select name, intro from project where id=".$id;
	$result = $dbh->query($query);
	if ($result) {
		$result_arr = $result->fetch(PDO::FETCH_ASSOC);
		$name = stripslashes($result_arr['name']);
		$intro = stripslashes($result_arr['intro']);
	}
?>
	<form action="modify.php" method="post" id="modform">
		<input type="hidden" name="id" value="<?php echo $id; ?>" />
		<p>项目名称：<br /><input type="text" id="name" name="projectname" size="30" required value="<?php echo $name; ?>"/></p>
		<p>简　　介：<br /><textarea rows="10" cols="32" name="introduction" ><?php echo $intro; ?></textarea></p>
	</form>	
	<button id="modifybtn"> 
	修改
	</button>
	<button id="backbtn">
	返回
	</button>
	<script>
		function formsubmit(){
			document.getElementById('modform').submit();
		}

		function moveback(){
			window.location = "project.php";
		}
		document.getElementById("modifybtn").onclick=function(){formsubmit()};
		document.getElementById("backbtn").onclick=moveback;
	</script>
</body>
</html>
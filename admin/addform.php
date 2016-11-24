<?php
	session_start();
	if(!$_SESSION['valid_user']){
		echo '<!DOCTYPE html><html><head>'
			.'<meta http-equiv="Content-Type" content="text/html; charset=utf-8">'.'<title>添加项目列表</title></head><body>';
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
	<title>添加项目列表</title>
</head>
<body>
	<form action="add.php" method="post" id="addform">
		<p>项目名称：<br /><input type="text" name="projectname" size="30" id="name" required/></p>
		<p>简　　介：<br /><textarea rows="10" cols="32" name="introduction"></textarea></p>
	</form>
	<button id="addbtn"> 
	添加
	</button>
	<button id="backbtn">
	返回
	</button>
	<script>
		function formsubmit(){
			if (document.getElementById("name").value == "") {
				window.alert("项目名称不能为空!");
				return false;
			}
			document.getElementById('addform').submit();
		}

		function moveback(){
			window.location = "project.php";
		}
		document.getElementById("addbtn").onclick=function(){formsubmit()};
		document.getElementById("backbtn").onclick=moveback;
	</script>
</body>
</html>
<?php
	session_start();

	// store to test if they "were" logged in
	$old_user = $_SESSION['valid_user'];
	unset($_SESSION['valid_user']);
	session_destroy;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>退出</title>
</head>
<body>
	<?php
		if(!empty($old_user)){
			echo "<p>您已成功退出.</p>";
		} else {
			// if they weren't logged in but came to this page somehow
			echo '<p>您尚未登录，无法退出.</p>';
		}
	?>
	<a href="../">返回主页</a>
</body>
</html>
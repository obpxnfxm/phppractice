<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"  />
    <title>浏览文件上传目录</title>
</head>
<body>
	<h1>目录浏览</h1>
	<?php
		$current_dir = '../../uploads/';
		$dir = opendir($current_dir);

		echo "<p>文件上传目录为：$current_dir</p>";
		echo "<p>目录列表如下：</p><ul>";

		while(false != ($file = readdir($dir)))
		{
			// 去除 . 和 .. 目录项
			if($file != "." and $file != "..")
			{
				echo "<li>$file</li>";
			}
		}
		echo '</ul>';
		closedir($dir);
	?>
</body>
</html>
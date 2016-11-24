<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"  />
    <title>浏览目录2</title>
</head>
<body>
	<?php
		$dir = dir("../../uploads");

		echo "<p>Handle is: $dir->handle</p>";
		echo "<p>Upload directory is: $dir->path</p>";
		echo "<p>Directory Listing:</p><ul>";

		while(false != ($file = $dir->read()))
		{
			// strip out the two entries of . and ..
			if($file != "." && $file !="..")
			{
				echo "<li>$file</li>";
			}
		}
			echo "</ul>";
			$dir->close();
	?>
	
</body>
</html>
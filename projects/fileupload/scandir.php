<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"  />
    <title>浏览排序的目录项</title>
</head>
<body>
	<h1>浏览排序的目录项</h1>
	<?php
		$dir = '../../uploads/';
		$files1 = scandir($dir);			// or SCANDIR_SORT_ASCENDING 
		$files2 = scandir($dir, 1);         // 1 or SCANDIR_SORT_DESCENDING

		// print in ascending order
		echo "<p>Upload directory is $dir</p>";
		echo "<p>Directory Listing in alphabetical order, ascending:</p<ul>";

		foreach($files1 as $file)
		{
			if($file !='.' && $file !='..')
			{
				echo "<li>$file</list>";
			}
		}
		echo "</ul>";

		//print in descending order
		echo "<p>Upload directory is $dir</p>";
		echo "<p>Directory Listing in alphabetical order, descending:</p<ul>";

		foreach($files2 as $file)
		{
			if($file !='.' && $file !='..')
			{
				echo "<li>$file</list>";
			}
		}
		echo "</ul>";
	?>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?php echo ($_POST['encoding']? "GBK" : "UTF-8"); #用户选择编码?>" />
    <title>Browser FTP</title>
</head>
<body>
	<?php
		$user = $_POST['username'];
		$pwd = $_POST['password'];
		$ftp = $_POST['ftpaddress'];
		echo "<h1>FTP Server: $ftp</h1>";

		// connect to ftp
		$conn = ftp_connect($ftp);
		if (!$conn) {
			echo "<p> Error：Can not connected to $ftp </p>";
			exit;
		}
		echo "Successfully connect to $ftp<br />";

		//log in to ftp
		@$result = ftp_login($conn, $user, $pwd);
		if (!$result){
			echo "<p>Error：Can not log in to $ftp</p>";
			ftp_quit($conn);
			exit;
		}
		echo "Successfully log in to $ftp<br />";
		echo "<hr />";

		// browsing ftp, 不获取目录
		//$listing = ftp_nlist($conn,".");

		// 显示详细信息
		$listing = ftp_rawlist($conn, ".");
		if ($listing) {
			foreach ($listing as $filedetails) {
				$filename = substr($filedetails, 55);
				$filetype = substr($filedetails, 0, 1);

				// 若为目录，给其加上链接
				if (!strcmp($filetype, 'd')) {
					echo "<a href=\""."ftp://$ftp/".urlencode($filename)."/"."\">".$filename."</a><br />";
				}
			}
		} else {
			echo "No files!<br />";
		}
	?>
</body>
</html>